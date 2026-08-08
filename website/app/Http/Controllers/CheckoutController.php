<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Support\ShoppingCart;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function store(Request $request, ShoppingCart $cart): View|RedirectResponse
    {
        $items = $cart->items();

        if ($items->isEmpty()) {
            return to_route('shop.cart')->withErrors(['cart' => 'Your cart is empty.']);
        }

        if (blank(config('cashier.client_side_token')) || blank(config('cashier.api_key'))) {
            throw ValidationException::withMessages([
                'cart' => 'Secure checkout is temporarily unavailable. Please try again later.',
            ]);
        }

        $currencies = $items->pluck('product.currency')->unique();

        if ($currencies->count() !== 1 || $items->contains(fn (array $item): bool => ! $item['product']->isPurchasable())) {
            throw ValidationException::withMessages([
                'cart' => 'One or more cart items are not currently available for checkout.',
            ]);
        }

        $requiresShipping = $items->contains(
            fn (array $item): bool => $item['product']->type === Product::TYPE_BOARD_GAME,
        );

        $shipping = $requiresShipping
            ? $request->validate([
                'shipping_name' => ['required', 'string', 'max:255'],
                'shipping_phone' => ['required', 'string', 'max:40'],
                'shipping_address_line_1' => ['required', 'string', 'max:255'],
                'shipping_address_line_2' => ['nullable', 'string', 'max:255'],
                'shipping_city' => ['required', 'string', 'max:120'],
                'shipping_postal_code' => ['required', 'string', 'max:20'],
                'shipping_country' => ['required', 'in:MK'],
            ])
            : [];

        if ($requiresShipping) {
            $cart->rememberDeliveryAddress($shipping);
        }

        $order = DB::transaction(function () use ($request, $items, $cart, $requiresShipping, $shipping): Order {
            $orderData = [
                'status' => Order::STATUS_PENDING,
                'total' => $cart->total(),
                'currency' => $items->first()['product']->currency,
                'requires_shipping' => $requiresShipping,
                'delivery_status' => $requiresShipping ? Order::DELIVERY_AWAITING_PAYMENT : null,
                ...$shipping,
            ];

            $expectedItems = $items
                ->mapWithKeys(fn (array $item): array => [
                    $item['product']->id => [
                        'paddle_price_id' => $item['product']->paddle_price_id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['product']->price,
                    ],
                ])
                ->sortKeys()
                ->all();

            $order = $request->user()->orders()
                ->where('status', Order::STATUS_PENDING)
                ->where('total', $orderData['total'])
                ->where('currency', $orderData['currency'])
                ->latest('id')
                ->lockForUpdate()
                ->get()
                ->first(function (Order $pendingOrder) use ($expectedItems): bool {
                    $actualItems = $pendingOrder->items()
                        ->get()
                        ->mapWithKeys(fn ($item): array => [
                            $item->product_id => [
                                'paddle_price_id' => $item->paddle_price_id,
                                'quantity' => $item->quantity,
                                'unit_price' => $item->unit_price,
                            ],
                        ])
                        ->sortKeys()
                        ->all();

                    return $actualItems === $expectedItems;
                });

            if ($order) {
                $order->update($orderData);

                return $order;
            }

            $order = $request->user()->orders()->create($orderData);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'paddle_price_id' => $item['product']->paddle_price_id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['product']->price,
                ]);
            }

            return $order;
        });

        return $this->checkoutView($request, $order);
    }

    public function retry(Request $request, Order $order): View|RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        if (! $order->isPending()) {
            return to_route('orders.index')->withErrors([
                'order' => 'Only orders awaiting payment can be resumed.',
            ]);
        }

        return $this->checkoutView($request, $order);
    }

    public function cancel(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        if (! $order->isPending()) {
            return to_route('orders.index')->withErrors([
                'order' => 'Paid orders cannot be cancelled here. Please use the refund contact process if you need help.',
            ]);
        }

        $order->update([
            'status' => Order::STATUS_CANCELLED,
            'delivery_status' => null,
        ]);

        return to_route('orders.index')->with('success', "Order #{$order->id} was cancelled.");
    }

    public function success(Request $request, Order $order, ShoppingCart $cart): View
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        $cart->clear();

        return view('shop.success', ['order' => $order->fresh('items.product')]);
    }

    public function status(Request $request, Order $order): JsonResponse
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        return response()
            ->json(['completed' => $order->fresh()->isCompleted()])
            ->header('Cache-Control', 'no-store, private');
    }

    private function checkoutView(Request $request, Order $order): View
    {
        if (blank(config('cashier.client_side_token')) || blank(config('cashier.api_key'))) {
            throw ValidationException::withMessages([
                'order' => 'Secure checkout is temporarily unavailable. Please try again later.',
            ]);
        }

        $order->loadMissing('items');

        if ($order->items->isEmpty() || $order->items->contains(fn ($item): bool => blank($item->paddle_price_id))) {
            throw ValidationException::withMessages([
                'order' => 'This order no longer has valid products for checkout.',
            ]);
        }

        $paddleItems = $order->items
            ->mapWithKeys(fn ($item): array => [$item->paddle_price_id => $item->quantity])
            ->all();

        $checkout = $request->user()
            ->checkout($paddleItems)
            ->customData(['order_id' => (string) $order->id])
            ->returnTo(route('shop.checkout.success', $order));

        return view('shop.checkout', compact('checkout', 'order'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Support\ShoppingCart;
use Illuminate\Contracts\View\View;
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

        $order = DB::transaction(function () use ($request, $items, $cart): Order {
            $order = $request->user()->orders()->create([
                'status' => Order::STATUS_PENDING,
                'total' => $cart->total(),
                'currency' => $items->first()['product']->currency,
            ]);

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

        $paddleItems = $items->mapWithKeys(
            fn (array $item): array => [$item['product']->paddle_price_id => $item['quantity']],
        )->all();

        $checkout = $request->user()
            ->checkout($paddleItems)
            ->customData(['order_id' => (string) $order->id])
            ->returnTo(route('shop.checkout.success', $order));

        $cart->clear();

        return view('shop.checkout', compact('checkout', 'order'));
    }

    public function success(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        return view('shop.success', ['order' => $order->fresh('items.product')]);
    }
}

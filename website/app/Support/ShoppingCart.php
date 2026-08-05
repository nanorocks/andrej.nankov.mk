<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class ShoppingCart
{
    private const SESSION_KEY = 'shop.cart';

    public function add(Product $product, int $quantity = 1): void
    {
        if (! $product->isPurchasable()) {
            throw ValidationException::withMessages([
                'cart' => "{$product->name} is not available for purchase yet.",
            ]);
        }

        $cart = $this->raw();
        $maximum = $product->type === Product::TYPE_EBOOK ? 1 : 10;
        $cart[$product->id] = min(($cart[$product->id] ?? 0) + $quantity, $maximum);

        session()->put(self::SESSION_KEY, $cart);
    }

    public function update(Product $product, int $quantity): void
    {
        $cart = $this->raw();

        if ($quantity < 1) {
            unset($cart[$product->id]);
        } else {
            $maximum = $product->type === Product::TYPE_EBOOK ? 1 : 10;
            $cart[$product->id] = min($quantity, $maximum);
        }

        session()->put(self::SESSION_KEY, $cart);
    }

    public function remove(Product $product): void
    {
        $cart = $this->raw();
        unset($cart[$product->id]);
        session()->put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function items(): Collection
    {
        $cart = $this->raw();

        if ($cart === []) {
            return collect();
        }

        return Product::query()
            ->whereIn('id', array_keys($cart))
            ->get()
            ->map(fn (Product $product): array => [
                'product' => $product,
                'quantity' => (int) $cart[$product->id],
                'subtotal' => $product->price * (int) $cart[$product->id],
            ]);
    }

    public function count(): int
    {
        return array_sum($this->raw());
    }

    public function total(): int
    {
        return (int) $this->items()->sum('subtotal');
    }

    private function raw(): array
    {
        return collect(session()->get(self::SESSION_KEY, []))
            ->mapWithKeys(fn ($quantity, $productId): array => [(int) $productId => max(1, (int) $quantity)])
            ->all();
    }
}

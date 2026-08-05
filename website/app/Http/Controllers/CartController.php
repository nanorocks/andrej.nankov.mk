<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\ShoppingCart;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(ShoppingCart $cart): View
    {
        return view('shop.cart', [
            'items' => $cart->items(),
            'total' => $cart->total(),
        ]);
    }

    public function store(Product $product, ShoppingCart $cart): RedirectResponse
    {
        $cart->add($product);

        return to_route('shop.cart')->with('success', "{$product->name} was added to your cart.");
    }

    public function update(Request $request, Product $product, ShoppingCart $cart): RedirectResponse
    {
        $validated = $request->validate(['quantity' => ['required', 'integer', 'min:0', 'max:10']]);
        $cart->update($product, $validated['quantity']);

        return to_route('shop.cart')->with('success', 'Cart updated.');
    }

    public function destroy(Product $product, ShoppingCart $cart): RedirectResponse
    {
        $cart->remove($product);

        return to_route('shop.cart')->with('success', 'Item removed from your cart.');
    }
}

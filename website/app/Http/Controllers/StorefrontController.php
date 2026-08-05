<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\ShoppingCart;
use Illuminate\Contracts\View\View;

class StorefrontController extends Controller
{
    public function __invoke(ShoppingCart $cart): View
    {
        return view('shop.index', [
            'products' => Product::visible()->get(),
            'cartCount' => $cart->count(),
        ]);
    }
}

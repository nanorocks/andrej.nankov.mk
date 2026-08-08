<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function __invoke(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->with('items.product')
            ->latest('id')
            ->paginate(5);

        return view('orders.index', compact('orders'));
    }
}

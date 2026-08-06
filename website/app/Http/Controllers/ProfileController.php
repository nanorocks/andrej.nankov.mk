<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __invoke(Request $request): View
    {
        $downloads = Product::query()
            ->where('type', Product::TYPE_EBOOK)
            ->whereHas('orderItems.order', fn ($query) => $query
                ->where('user_id', $request->user()->id)
                ->where('status', Order::STATUS_COMPLETED))
            ->orderBy('name')
            ->get();

        $transactions = $request->user()
            ->transactions()
            ->latest('billed_at')
            ->get();

        return view('profile', compact('downloads', 'transactions'));
    }
}

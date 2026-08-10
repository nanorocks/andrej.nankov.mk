<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EbookDownloadController extends Controller
{
    public function __invoke(Request $request, Product $product): StreamedResponse
    {
        abort_unless($product->type === Product::TYPE_EBOOK && filled($product->download_path), 404);

        $ownsProduct = $product->orderItems()
            ->whereHas('order', fn ($query) => $query
                ->where('user_id', $request->user()->id)
                ->where('status', Order::STATUS_COMPLETED))
            ->exists();

        abort_unless($ownsProduct && Storage::disk('local')->exists($product->download_path), 404);

        return Storage::disk('local')->download(
            $product->download_path,
            $product->slug.'.pdf',
            ['Content-Type' => 'application/pdf'],
        );
    }
}

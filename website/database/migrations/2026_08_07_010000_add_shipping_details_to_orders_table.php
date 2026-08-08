<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->boolean('requires_shipping')->default(false)->after('currency')->index();
            $table->string('delivery_status')->nullable()->after('requires_shipping')->index();
            $table->string('shipping_name')->nullable()->after('delivery_status');
            $table->string('shipping_phone', 40)->nullable()->after('shipping_name');
            $table->string('shipping_address_line_1')->nullable()->after('shipping_phone');
            $table->string('shipping_address_line_2')->nullable()->after('shipping_address_line_1');
            $table->string('shipping_city', 120)->nullable()->after('shipping_address_line_2');
            $table->string('shipping_postal_code', 20)->nullable()->after('shipping_city');
            $table->char('shipping_country', 2)->nullable()->after('shipping_postal_code');
            $table->timestamp('shipped_at')->nullable()->after('completed_at');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
        });

        $physicalOrderIds = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('products.type', Product::TYPE_BOARD_GAME)
            ->distinct()
            ->pluck('order_items.order_id');

        if ($physicalOrderIds->isNotEmpty()) {
            DB::table('orders')
                ->whereIn('id', $physicalOrderIds)
                ->update([
                    'requires_shipping' => true,
                    'delivery_status' => 'address_required',
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->dropIndex(['requires_shipping']);
            $table->dropIndex(['delivery_status']);
            $table->dropColumn([
                'requires_shipping',
                'delivery_status',
                'shipping_name',
                'shipping_phone',
                'shipping_address_line_1',
                'shipping_address_line_2',
                'shipping_city',
                'shipping_postal_code',
                'shipping_country',
                'shipped_at',
                'delivered_at',
            ]);
        });
    }
};

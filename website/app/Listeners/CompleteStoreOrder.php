<?php

namespace App\Listeners;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Laravel\Paddle\Events\TransactionCompleted;

class CompleteStoreOrder
{
    public function handle(TransactionCompleted $event): void
    {
        $orderId = data_get($event->payload, 'data.custom_data.order_id');

        if (! is_numeric($orderId)) {
            return;
        }

        DB::transaction(function () use ($event, $orderId): void {
            $order = Order::query()->lockForUpdate()->find($orderId);

            if (! $order || $order->user_id !== $event->billable->getKey() || $order->isCompleted()) {
                return;
            }

            $order->update([
                'status' => Order::STATUS_COMPLETED,
                'total' => (int) $event->transaction->getAttribute('total'),
                'currency' => $event->transaction->currency,
                'paddle_transaction_id' => $event->transaction->paddle_id,
                'completed_at' => now(),
                'delivery_status' => $order->requires_shipping
                    ? Order::DELIVERY_READY_TO_SHIP
                    : null,
            ]);
        });
    }
}

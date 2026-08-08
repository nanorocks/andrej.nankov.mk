<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->modalHeading('Delete order')
                ->modalDescription('This permanently deletes the order and its items. Any digital download access granted by this order will also be removed.')
                ->successNotificationTitle('Order deleted'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /** @var Order $order */
        $order = $this->record;

        if (($data['delivery_status'] ?? null) === Order::DELIVERY_SHIPPED && ! $order->shipped_at) {
            $data['shipped_at'] = now();
        }

        if (($data['delivery_status'] ?? null) === Order::DELIVERY_DELIVERED && ! $order->delivered_at) {
            $data['shipped_at'] = $order->shipped_at ?? now();
            $data['delivered_at'] = now();
        }

        return $data;
    }
}

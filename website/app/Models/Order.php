<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    public const DELIVERY_ADDRESS_REQUIRED = 'address_required';

    public const DELIVERY_AWAITING_PAYMENT = 'awaiting_payment';

    public const DELIVERY_READY_TO_SHIP = 'ready_to_ship';

    public const DELIVERY_PROCESSING = 'processing';

    public const DELIVERY_SHIPPED = 'shipped';

    public const DELIVERY_DELIVERED = 'delivered';

    protected $fillable = [
        'user_id',
        'status',
        'total',
        'currency',
        'requires_shipping',
        'delivery_status',
        'shipping_name',
        'shipping_phone',
        'shipping_address_line_1',
        'shipping_address_line_2',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
        'paddle_transaction_id',
        'completed_at',
        'shipped_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'integer',
            'requires_shipping' => 'boolean',
            'completed_at' => 'datetime',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function paymentStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_COMPLETED => 'Paid',
            self::STATUS_CANCELLED => 'Cancelled',
            default => 'Payment pending',
        };
    }

    public static function deliveryStatusOptions(): array
    {
        return [
            self::DELIVERY_ADDRESS_REQUIRED => 'Address required',
            self::DELIVERY_AWAITING_PAYMENT => 'Awaiting payment',
            self::DELIVERY_READY_TO_SHIP => 'Ready to ship',
            self::DELIVERY_PROCESSING => 'Processing',
            self::DELIVERY_SHIPPED => 'Shipped',
            self::DELIVERY_DELIVERED => 'Delivered',
        ];
    }

    public function deliveryStatusLabel(): ?string
    {
        return self::deliveryStatusOptions()[$this->delivery_status] ?? null;
    }

    public function customerDeliveryStatusLabel(): ?string
    {
        if (! $this->requires_shipping || $this->isCancelled()) {
            return null;
        }

        if ($this->delivery_status === self::DELIVERY_ADDRESS_REQUIRED) {
            return 'Preparing delivery';
        }

        return $this->deliveryStatusLabel()
            ?? ($this->isCompleted() ? 'Preparing delivery' : 'Awaiting payment');
    }
}

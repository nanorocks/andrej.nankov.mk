<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public const TYPE_BOARD_GAME = 'board_game';

    public const TYPE_EBOOK = 'ebook';

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'price',
        'currency',
        'paddle_price_id',
        'download_path',
        'is_active',
        'is_coming_soon',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'is_active' => 'boolean',
            'is_coming_soon' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('name');
    }

    public function isPurchasable(): bool
    {
        return $this->is_active && ! $this->is_coming_soon && filled($this->paddle_price_id);
    }

    public function formattedPrice(): string
    {
        return number_format($this->price / 100, 2).' '.$this->currency;
    }
}

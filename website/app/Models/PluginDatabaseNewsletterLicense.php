<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginDatabaseNewsletterLicense extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plugin_database_newsletter_licenses';

    protected $fillable = [
        'license_key',
        'assigned_to',
        'active',
        'expires_at',
        'metadata',
    ];

    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Check if license is valid
     */
    public function isValid(): bool
    {
        return $this->active && (! $this->expires_at || $this->expires_at->isFuture());
    }
}

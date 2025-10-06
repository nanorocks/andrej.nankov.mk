<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'period_type',
        'period_start',
        'period_end',
        'trips_completed',
        'distance_km',
        'driving_hours',
        'on_time_rate',
        'rating',
        'accidents_count',
        'incidents_count',
        'infractions_count',
        'fuel_used_liters',
        'fuel_efficiency_km_per_l',
        'avg_speed_kmh',
        'score',
        'metrics',
        'last_evaluated_at',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'driving_hours' => 'decimal:2',
        'on_time_rate' => 'decimal:2',
        'rating' => 'decimal:2',
        'fuel_used_liters' => 'decimal:2',
        'fuel_efficiency_km_per_l' => 'decimal:2',
        'avg_speed_kmh' => 'decimal:2',
        'metrics' => 'array',
        'last_evaluated_at' => 'datetime',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleService extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'service_type',
        'title',
        'description',
        'due_date',
        'due_mileage',
        'interval_months',
        'interval_mileage',
        'priority',
        'status',
        'scheduled_at',
        'completed_at',
        'vendor_name',
        'vendor_contact',
        'estimated_cost',
        'reminder_offset_days',
        'reminder_at',
        'meta',
    ];

    protected $casts = [
        'due_date' => 'date',
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'reminder_at' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'meta' => 'array',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}

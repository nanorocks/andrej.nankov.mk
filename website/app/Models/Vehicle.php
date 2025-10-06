<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        // core identifiers if present
        'driver_id',
        'vin',
        'registration_number',
        'status',
        'purchased_at',
        'notes',
    ];

    protected $casts = [
        'purchased_at' => 'date',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function attributes()
    {
        return $this->hasMany(VehicleAttribute::class);
    }

    public function services()
    {
        return $this->hasMany(VehicleService::class);
    }
}

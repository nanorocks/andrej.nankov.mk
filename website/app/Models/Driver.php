<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'license_category',
        'license_issued_at',
        'license_expires_at',
        'phone',
        'address',
        'date_of_birth',
        'status',
        'attributes',
    ];

    protected $casts = [
        'license_issued_at' => 'date',
        'license_expires_at' => 'date',
        'date_of_birth' => 'date',
        'attributes' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function performances()
    {
        return $this->hasMany(DriverPerformance::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'driver_id');
    }
}

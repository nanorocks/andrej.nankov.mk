<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    // Table name (optional, if not 'subscribers')
    protected $table = 'subscribers';

    // Fillable fields for mass assignment
    protected $fillable = [
        'email',
    ];

    // Optional: Validation rules for newsletter subscription
    public static function rules()
    {
        return [
            'email' => 'required|email|unique:subscribers,email',
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingSetting extends Model
{
    protected $fillable = [
        'extra_guest_threshold',
        'extra_guest_price',
        'cleaning_fee',
        'tax_rate',
    ];

    protected $casts = [
        'extra_guest_threshold' => 'integer',
        'extra_guest_price'     => 'float',
        'cleaning_fee'          => 'float',
        'tax_rate'              => 'float',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'extra_guest_threshold' => 6,
            'extra_guest_price'     => 100.00,
            'cleaning_fee'          => 795.00,
            'tax_rate'              => 12.00,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinimumStay extends Model
{
    protected $fillable = [
        'day_of_week',
        'day_name',
        'minimum_nights',
    ];

    protected $casts = [
        'day_of_week'     => 'integer',
        'minimum_nights'  => 'integer',
    ];

    public static function forDow(int $dow): int
    {
        $row = static::where('day_of_week', $dow)->first();
        return $row ? $row->minimum_nights : 1;
    }
}

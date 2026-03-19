<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'payment_intent_id',
        'name',
        'email',
        'phone',
        'checkin',
        'checkout',
        'guests',
        'nights',
        'subtotal',
        'cleaning_fee',
        'tax_amount',
        'total',
        'status',
    ];

    protected $casts = [
        'checkin'      => 'date',
        'checkout'     => 'date',
        'guests'       => 'integer',
        'nights'       => 'integer',
        'subtotal'     => 'decimal:2',
        'cleaning_fee' => 'decimal:2',
        'tax_amount'   => 'decimal:2',
        'total'        => 'decimal:2',
    ];
}

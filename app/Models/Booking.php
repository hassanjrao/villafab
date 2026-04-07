<?php

namespace App\Models;

use Carbon\Carbon;
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
        'extra_guest_charges',
        'cleaning_fee',
        'tax_amount',
        'total',
        'status',
        'payment_type',
        'stripe_customer_id',
        'stripe_payment_method_id',
        'card_update_token',
        'amount_paid',
        'balance_due',
        'balance_charge_date',
        'balance_status',
        'balance_reminder_sent_at',
        'balance_failure_notified_at',
        'notes',
    ];

    protected $casts = [
        'checkin'                     => 'date',
        'checkout'                    => 'date',
        'guests'                      => 'integer',
        'nights'                      => 'integer',
        'subtotal'                    => 'decimal:2',
        'extra_guest_charges'         => 'decimal:2',
        'cleaning_fee'                => 'decimal:2',
        'tax_amount'                  => 'decimal:2',
        'total'                       => 'decimal:2',
        'amount_paid'                 => 'decimal:2',
        'balance_due'                 => 'decimal:2',
        'balance_charge_date'         => 'date',
        'balance_reminder_sent_at'    => 'datetime',
        'balance_failure_notified_at' => 'datetime',
    ];

    public function scopePendingBalance($query)
    {
        return $query->where('payment_type', 'deferred')
                     ->whereIn('balance_status', ['pending', 'failed']);
    }

    public function scopeBalanceDueOn($query, $date)
    {
        return $query->whereDate('balance_charge_date', Carbon::parse($date)->toDateString());
    }

    public function scopeFailedBalance($query)
    {
        return $query->where('balance_status', 'failed');
    }
}

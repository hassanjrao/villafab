<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatePeriod extends Model
{
    protected $fillable = [
        'sort_order',
        'date_from',
        'date_to',
        'monday_rate',
        'tuesday_rate',
        'wednesday_rate',
        'thursday_rate',
        'friday_rate',
        'saturday_rate',
        'sunday_rate',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to'   => 'date',
    ];

    /** Map PHP day-of-week integer (0=Sun…6=Sat) to column name */
    public static function dayColumn(int $dow): string
    {
        $map = [
            0 => 'sunday_rate',
            1 => 'monday_rate',
            2 => 'tuesday_rate',
            3 => 'wednesday_rate',
            4 => 'thursday_rate',
            5 => 'friday_rate',
            6 => 'saturday_rate',
        ];

        return $map[$dow] ?? 'monday_rate';
    }

    /**
     * Find the rate for a given date.
     * Falls back to period 1 (the default/base period) if no range matches.
     */
    public static function rateForDate(\Carbon\Carbon $date): ?float
    {
        $col = self::dayColumn((int) $date->dayOfWeek);

        $periods = self::orderBy('sort_order')->get();

        // Try to find a period whose date range covers $date
        foreach ($periods as $period) {
            if ($period->date_from && $period->date_to) {
                if ($date->between($period->date_from, $period->date_to)) {
                    return $period->{$col} ? (float) $period->{$col} : null;
                }
            }
        }

        // Fall back to the first period (default rates, no date range required)
        $default = $periods->first();
        return $default ? ((float) ($default->{$col} ?? 0)) : null;
    }
}

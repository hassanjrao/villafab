<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarFeed extends Model
{
    protected $fillable = [
        'name',
        'ics_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Return an array of ICS URLs for all active feeds.
     */
    public static function activeUrls(): array
    {
        return static::where('is_active', true)
            ->pluck('ics_url')
            ->all();
    }
}

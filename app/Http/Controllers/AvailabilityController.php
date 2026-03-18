<?php

namespace App\Http\Controllers;

use ICal\ICal;
use Illuminate\Http\JsonResponse;

class AvailabilityController extends Controller
{
    public function bookedDates(): JsonResponse
    {
        try {
            $ical = new ICal(env('GOOGLE_CAL_ICS_URL'), [
                'defaultSpan'      => 2,
                'defaultTimeZone'  => 'America/Los_Angeles',
                'skipRecurrence'   => false,
            ]);

            $events = collect($ical->events())->map(function ($event) use ($ical) {
                return [
                    'title'   => 'Booked',
                    'start'   => $ical->iCalDateToDateTime($event->dtstart)->format('Y-m-d'),
                    'end'     => $ical->iCalDateToDateTime($event->dtend)->format('Y-m-d'),
                    'color'   => '#e74c3c',
                    'display' => 'background',
                ];
            })->values();

            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }
}

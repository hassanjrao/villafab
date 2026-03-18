<?php

namespace App\Http\Controllers;

use App\Models\MinimumStay;
use App\Models\PricingSetting;
use App\Models\RatePeriod;
use Illuminate\Http\Request;

class AdminPricingController extends Controller
{
    public function index()
    {
        $settings    = PricingSetting::current();
        $ratePeriods = RatePeriod::orderBy('sort_order')->get();
        $minimumStays = MinimumStay::orderBy('day_of_week')->get()
            ->keyBy('day_of_week');

        // Ensure we always pass 7 days in display order (Mon–Sun)
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            0 => 'Sunday',
        ];

        return view('admin.pricing.index', compact(
            'settings',
            'ratePeriods',
            'minimumStays',
            'days'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings.extra_guest_threshold' => 'required|integer|min:1',
            'settings.extra_guest_price'     => 'required|numeric|min:0',
            'settings.cleaning_fee'          => 'required|numeric|min:0',
            'settings.tax_rate'              => 'required|numeric|min:0|max:100',

            'periods.*.date_from'      => 'nullable|date',
            'periods.*.date_to'        => 'nullable|date|after_or_equal:periods.*.date_from',
            'periods.*.monday_rate'    => 'nullable|numeric|min:0',
            'periods.*.tuesday_rate'   => 'nullable|numeric|min:0',
            'periods.*.wednesday_rate' => 'nullable|numeric|min:0',
            'periods.*.thursday_rate'  => 'nullable|numeric|min:0',
            'periods.*.friday_rate'    => 'nullable|numeric|min:0',
            'periods.*.saturday_rate'  => 'nullable|numeric|min:0',
            'periods.*.sunday_rate'    => 'nullable|numeric|min:0',

            'stays.*.minimum_nights' => 'required|integer|min:1',
        ]);

        // Update global settings
        PricingSetting::current()->update($request->input('settings'));

        // Update rate periods
        foreach ($request->input('periods', []) as $id => $data) {
            RatePeriod::where('id', $id)->update([
                'date_from'      => $data['date_from']      ?: null,
                'date_to'        => $data['date_to']        ?: null,
                'monday_rate'    => $data['monday_rate']    ?: null,
                'tuesday_rate'   => $data['tuesday_rate']   ?: null,
                'wednesday_rate' => $data['wednesday_rate'] ?: null,
                'thursday_rate'  => $data['thursday_rate']  ?: null,
                'friday_rate'    => $data['friday_rate']    ?: null,
                'saturday_rate'  => $data['saturday_rate']  ?: null,
                'sunday_rate'    => $data['sunday_rate']    ?: null,
            ]);
        }

        // Update minimum stays
        foreach ($request->input('stays', []) as $dow => $data) {
            MinimumStay::where('day_of_week', $dow)
                ->update(['minimum_nights' => $data['minimum_nights']]);
        }

        return redirect()->route('admin.pricing.index')
            ->with('success', 'Pricing settings saved successfully.');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendar_feeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('ics_url');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('calendar_feeds')->insert([
            [
                'name'       => 'Airbnb',
                'ics_url'    => 'https://calendar.google.com/calendar/ical/s35jtr5o7ji7kt5ueejovji3g4jfut7e%40import.calendar.google.com/public/basic.ics',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'VRBO',
                'ics_url'    => 'https://calendar.google.com/calendar/ical/mic7ecf0ujquqrn2c87ht0670d4ktf7l%40import.calendar.google.com/public/basic.ics',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('calendar_feeds');
    }
};

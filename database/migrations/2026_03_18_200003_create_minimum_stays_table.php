<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMinimumStaysTable extends Migration
{
    public function up()
    {
        Schema::create('minimum_stays', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('day_of_week'); // 0=Sun, 1=Mon … 6=Sat
            $table->string('day_name');
            $table->unsignedTinyInteger('minimum_nights')->default(2);
            $table->timestamps();
        });

        $now = now();

        DB::table('minimum_stays')->insert([
            ['day_of_week' => 1, 'day_name' => 'Monday',    'minimum_nights' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['day_of_week' => 2, 'day_name' => 'Tuesday',   'minimum_nights' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['day_of_week' => 3, 'day_name' => 'Wednesday', 'minimum_nights' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['day_of_week' => 4, 'day_name' => 'Thursday',  'minimum_nights' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['day_of_week' => 5, 'day_name' => 'Friday',    'minimum_nights' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['day_of_week' => 6, 'day_name' => 'Saturday',  'minimum_nights' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['day_of_week' => 0, 'day_name' => 'Sunday',    'minimum_nights' => 2, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('minimum_stays');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRatePeriodsTable extends Migration
{
    public function up()
    {
        Schema::create('rate_periods', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('sort_order');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->decimal('monday_rate', 8, 2)->nullable();
            $table->decimal('tuesday_rate', 8, 2)->nullable();
            $table->decimal('wednesday_rate', 8, 2)->nullable();
            $table->decimal('thursday_rate', 8, 2)->nullable();
            $table->decimal('friday_rate', 8, 2)->nullable();
            $table->decimal('saturday_rate', 8, 2)->nullable();
            $table->decimal('sunday_rate', 8, 2)->nullable();
            $table->timestamps();
        });

        $now = now();

        DB::table('rate_periods')->insert([
            [
                'sort_order'     => 1,
                'date_from'      => null,
                'date_to'        => null,
                'monday_rate'    => 600.00,
                'tuesday_rate'   => 600.00,
                'wednesday_rate' => 600.00,
                'thursday_rate'  => 600.00,
                'friday_rate'    => 700.00,
                'saturday_rate'  => 900.00,
                'sunday_rate'    => 600.00,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'sort_order'     => 2,
                'date_from'      => null,
                'date_to'        => null,
                'monday_rate'    => null,
                'tuesday_rate'   => null,
                'wednesday_rate' => null,
                'thursday_rate'  => null,
                'friday_rate'    => null,
                'saturday_rate'  => null,
                'sunday_rate'    => null,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'sort_order'     => 3,
                'date_from'      => null,
                'date_to'        => null,
                'monday_rate'    => null,
                'tuesday_rate'   => null,
                'wednesday_rate' => null,
                'thursday_rate'  => null,
                'friday_rate'    => null,
                'saturday_rate'  => null,
                'sunday_rate'    => null,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('rate_periods');
    }
}

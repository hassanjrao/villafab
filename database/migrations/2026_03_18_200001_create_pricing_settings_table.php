<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePricingSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('pricing_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('extra_guest_threshold')->default(6);
            $table->decimal('extra_guest_price', 8, 2)->default(100.00);
            $table->decimal('cleaning_fee', 8, 2)->default(795.00);
            $table->decimal('tax_rate', 5, 2)->default(12.00);
            $table->timestamps();
        });

        DB::table('pricing_settings')->insert([
            'extra_guest_threshold' => 6,
            'extra_guest_price'     => 100.00,
            'cleaning_fee'          => 795.00,
            'tax_rate'              => 12.00,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('pricing_settings');
    }
}

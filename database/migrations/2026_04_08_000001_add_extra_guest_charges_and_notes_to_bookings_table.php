<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraGuestChargesAndNotesToBookingsTable extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('extra_guest_charges', 10, 2)->default(0)->after('subtotal');
            $table->text('notes')->nullable()->after('balance_failure_notified_at');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['extra_guest_charges', 'notes']);
        });
    }
}

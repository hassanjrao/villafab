<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeferredPaymentToBookingsTable extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('payment_type')->default('full')->after('status');
            $table->string('stripe_customer_id')->nullable()->after('payment_type');
            $table->string('stripe_payment_method_id')->nullable()->after('stripe_customer_id');
            $table->decimal('amount_paid', 10, 2)->nullable()->after('stripe_payment_method_id');
            $table->decimal('balance_due', 10, 2)->nullable()->after('amount_paid');
            $table->date('balance_charge_date')->nullable()->after('balance_due');
            $table->string('balance_status')->nullable()->after('balance_charge_date');
            $table->timestamp('balance_reminder_sent_at')->nullable()->after('balance_status');
            $table->timestamp('balance_failure_notified_at')->nullable()->after('balance_reminder_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_type',
                'stripe_customer_id',
                'stripe_payment_method_id',
                'amount_paid',
                'balance_due',
                'balance_charge_date',
                'balance_status',
                'balance_reminder_sent_at',
                'balance_failure_notified_at',
            ]);
        });
    }
}

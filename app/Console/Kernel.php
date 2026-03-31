<?php

namespace App\Console;

use App\Console\Commands\CancelFailedBookings;
use App\Console\Commands\ChargeBalances;
use App\Console\Commands\SendBalanceReminders;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendBalanceReminders::class,
        ChargeBalances::class,
        CancelFailedBookings::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(SendBalanceReminders::class)->everyMinute(); // For testing, change to dailyAt('08:00') in production
        $schedule->command(ChargeBalances::class)->dailyAt('09:00');
        $schedule->command(CancelFailedBookings::class)->dailyAt('10:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

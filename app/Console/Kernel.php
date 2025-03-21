<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('email:weekly-registered-users')->weeklyOn(1, '8:00'); // Every Monday at 8 AM
        $schedule->command('subscriptions:check-expired')->dailyAt('00:00');
        $schedule->command('customers:delete-unverified')->dailyAt('00:00');
        // $schedule->command('email:test')->dailyAt('00:00');
        $schedule->command('database:backup')->dailyAt('02:00'); // Runs at 2 AM daily
        $schedule->command('stripe:check-payout-status')->hourly();
        $schedule->command('winery-payments:capture')->daily('00:00');
        $schedule->command('accommodation-payments:capture')->daily('00:00');
        $schedule->command('cashback:approve')->daily('00:00');
        // $schedule->command('database:backup')->hourly();
        // $schedule->call(function () {
        //     \Log::info('Cron is running correctly.');
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use App\Console\Data\ExportData;
use App\Console\Data\GenerateBets;
use App\Console\Data\GenerateCurrencies;
use App\Console\Data\GeneratePaymentType;
use App\Console\Data\ImportData;
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
        ImportData::class,
        GenerateCurrencies::class,
        ExportData::class,
        GeneratePaymentType::class,
        GenerateBets::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->exec('php artisan data:import')->everyFiveMinutes();
        $schedule->exec('php artisan data:updated')->everyFourHours();
        $schedule->exec('php artisan data:currencies')->daily();
        $schedule->exec('php artisan data:export-db')->daily();
        $schedule->exec('php artisan data:payments-type')->daily();
        $schedule->exec('php artisan data:bets')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use App\Jobs\RunBackups;
use App\Jobs\RunDailyBackups;
use App\Jobs\RunHourlyBackups;
use App\Jobs\RunMonthlyBackups;
use App\Jobs\RunWeeklyBackups;
use App\Jobs\RunYearlyBackups;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('telescope:prune')->daily();
        $schedule->job(new RunBackups('hourly'))->hourly();
        $schedule->job(new RunBackups('daily'))->daily();
        $schedule->job(new RunBackups('weekly'))->weekly();
        $schedule->job(new RunBackups('monthly'))->monthly();
        $schedule->job(new RunBackups('yearly'))->yearly();
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

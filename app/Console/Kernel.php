<?php

namespace App\Console;

use Illuminate\Support\Facades\App;
use Illuminate\Console\Scheduling\Schedule;
use Afaqy\Contract\Console\CheckContractStatus;
use Afaqy\Dashboard\Console\DashboardDayLogSchedule;
use Afaqy\TripWorkflow\Console\TruncateRequestLogTable;
use Afaqy\Dashboard\Console\DashboardTotalWeightSchedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Afaqy\TripWorkflow\Console\DeleteLogOlderThanThirtyDays;

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
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        if(App::environment('test') || App::environment('develop')) {
            $schedule->command('migrate:fresh --seed')->dailyAt('00:00');
            $schedule->command('passport:client --password --no-interaction')->dailyAt('00:00');
            $schedule->command('module:seed')->dailyAt('00:00');
        }
        $schedule->call(new CheckContractStatus)->dailyAt('00:00');
        $schedule->call(new TruncateRequestLogTable)->dailyAt('03:00');
        $schedule->call(new DeleteLogOlderThanThirtyDays)->dailyAt('03:00');
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

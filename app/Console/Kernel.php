<?php namespace HRis\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'HRis\Console\Commands\ImportTimeLog',
        'HRis\Console\Commands\ImportEmployeeList',
        'HRis\Console\Commands\UpdateFaceId',
        'HRis\Console\Commands\GenerateAttendance',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
            ->hourly();
    }

}

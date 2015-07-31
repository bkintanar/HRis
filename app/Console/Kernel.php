<?php

namespace HRis\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 * @package HRis\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \HRis\Console\Commands\ImportTimeLog::class,
        \HRis\Console\Commands\ImportEmployeeList::class,
        \HRis\Console\Commands\UpdateFaceId::class,
        \HRis\Console\Commands\GenerateAttendance::class,
        \HRis\Console\Commands\Inspire::class,
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

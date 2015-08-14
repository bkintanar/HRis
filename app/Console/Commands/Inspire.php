<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

/**
 * Class Inspire.
 */
class Inspire extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}

<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Console\Commands;

use Exception;
use HRis\Api\Eloquent\Employee;
use HRis\Api\ThirdParty\Elastic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class IndexAllEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all employee document to elastic search client';

    /**
     * @var Elastic
     */
    protected $elastic;

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * Create a new command instance.
     *
     * @param Elastic  $elastic
     * @param Employee $employee
     */
    public function __construct(Elastic $elastic, Employee $employee)
    {
        parent::__construct();

        $this->elastic = $elastic;
        $this->employee = $employee;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = 0;

        try {
            $count = $this->elastic->indexAllEmployees($this->employee);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $message = $count.' objects are successfully re-indexed.';

        $this->comment(PHP_EOL.$message.PHP_EOL);

        Log::info($message);
    }
}

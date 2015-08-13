<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Console\Commands;

use HRis\Eloquent\Employee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;

/**
 * Class UpdateFaceId
 * @package HRis\Console\Commands
 */
class UpdateFaceId extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Face ID column in the employee table';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hris:update-face-id';

    /**
     * Execute the console command.
     *
     * @author Bertrand Kintanar
     */
    public function handle()
    {
        $csv = Reader::createFromPath(storage_path() . '/timelog.csv');

        $csv->setOffset(1);
        $data = $csv->query();

        foreach ($data as $lineIndex => $row) {
            $employee = Employee::whereEmployeeId($row[1])->first();

            if ($employee) {
                $employee->face_id = $row[0];
                $employee->save();

                $this->info($employee);
                Log::info($employee);
            }
        }
    }
}

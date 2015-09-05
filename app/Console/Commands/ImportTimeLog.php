<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Console\Commands;

use Carbon\Carbon;
use HRis\Eloquent\Timelog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;

/**
 * Class ImportTimelog.
 */
class ImportTimelog extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import timelog from a given CSV file';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hris:import-timelog';

    /**
     * Execute the console command.
     *
     * @author Bertrand Kintanar
     */
    public function handle()
    {
        $csv = Reader::createFromPath(storage_path().'/attendance.csv');

        $csv->setOffset(1);
        $data = $csv->query();

        foreach ($data as $lineIndex => $row) {
            $times = array_slice($row, 4, count($row) - 1);

            foreach ($times as $time) {
                if (empty($time)) {
                    continue;
                }

                $data = [
                    'face_id'        => $row[0],
                    'swipe_date'     => $row[3],
                    'swipe_time'     => $time,
                    'swipe_datetime' => Carbon::parse($row[3].' '.$time),
                ];
                $timelog = Timelog::create($data);

                $this->info($timelog);
                Log::info($timelog);
            }
        }
    }
}

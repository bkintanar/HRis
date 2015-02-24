<?php namespace HRis\Console\Commands;

use Carbon\Carbon;
use HRis\Eloquent\City;
use HRis\Eloquent\Employee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;

class UpdateFaceId extends Command {

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'update:face_id';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $csv = Reader::createFromPath(storage_path() . '/timelog.csv');

        $csv->setOffset(1);
        $data = $csv->query();

        foreach ($data as $lineIndex => $row)
        {
//            if($row[0] >  509)
//            print_r($row);
////            die;
////            $this->info($row);
            $employee = Employee::whereEmployeeId($row[1])->first();

            if ($employee)
            {
                $employee->face_id = $row[0];
                $employee->save();

                $this->info($employee);
                Log::info($employee);
            }
        }
    }

}

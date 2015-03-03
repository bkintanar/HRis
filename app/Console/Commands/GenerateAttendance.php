<?php namespace HRis\Console\Commands;

use Carbon\Carbon;
use HRis\Eloquent\Attendance;
use HRis\Eloquent\Employee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateAttendance extends Command {

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
    protected $name = 'generate:attendance';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $employee_ids = [11];

        foreach ($employee_ids as $employee_id)
        {
            $start = Carbon::parse('2015-01-01');
            $end = Carbon::parse('2015-01-31');
            while ($start <= $end)
            {

                $employee = Employee::whereId($employee_id)->first();

                $timelog = $employee->getTimeLog($start->toDateString());

                if ($timelog['in_time'] == null and $timelog['out_time'] == null)
                {
                    $start = $start->addDay(1);

                    continue;
                }

                $data = [
                    'employee_id' => $employee->id,
                    'work_date'   => $start->toDateString(),
                    'in_time'     => $timelog['in_time'],
                    'out_time'    => $timelog['out_time']
                ];

                $attendance = Attendance::create($data);

                $this->info($attendance);
                Log::info($attendance);

                $start = $start->addDay(1);
            }
        }
    }

}

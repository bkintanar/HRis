<?php

namespace HRis\Http\Controllers\Time\Attendance;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use HRis\Eloquent\Attendance;
use HRis\Eloquent\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests;
use Illuminate\Support\Facades\Input;

/**
 * Class EmployeeRecordsController
 * @package HRis\Http\Controllers\Time\Attendance
 *
 * @Middleware("auth")
 */
class EmployeeRecordsController extends Controller
{

    /**
     * @Get("time/attendance/employee-records")
     * @Get("time/attendance/employee-records/{date}")
     *
     * @param null $date
     * @return \Illuminate\View\View
     */
    public function index($date = null)
    {
        if (is_null($date)) {
            $date = Carbon::now()->toDateString();
        }
        $this->data['date'] = $date;
        $this->data['work_date'] = null;
        $this->data['employee'] = Employee::whereId(1)->first();
        $this->data['disabled'] = false;

        $this->data['employee_id'] = null;
        $this->data['pageTitle'] = 'Employee Records';

        return $this->template('pages.time.attendance.employee-records');
    }

    /**
     * @Post("time/attendance/employee-records")
     */
    public function show()
    {
        $work_date = Input::get('work_date');

        $start_date = Carbon::parse($work_date);
        $end_date = Carbon::parse($work_date)->endOfMonth();

        $period = new DatePeriod(
            $start_date,
            new DateInterval('P1D'),
            $end_date
        );

        $month = [];
        foreach ($period as $row) {
            $attendance = Attendance::where('work_date', '>=', $row->toDateString())->where('work_date', '<=',
                $row->toDateString())->whereEmployeeId(Input::get('employee_id'))->first();

            if ($attendance == null) {
                $month[$row->toDateString()] = null;

                continue;
            }

            $month[$row->toDateString()] = $attendance;
        }


        $this->data['employee_id'] = Input::get('employee_id');
        $this->data['work_date'] = $work_date;
        $this->data['attendance'] = $month;
        $this->data['pageTitle'] = 'Employee Records';

        return $this->template('pages.time.attendance.employee-records');
    }
}

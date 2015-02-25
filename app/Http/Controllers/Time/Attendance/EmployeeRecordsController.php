<?php namespace HRis\Http\Controllers\Time\Attendance;

use Carbon\Carbon;
use HRis\Eloquent\Employee;
use HRis\Http\Controllers\Controller;

/**
 * @Middleware("auth")
 */
class EmployeeRecordsController extends Controller {

    /**
     * @Get("time/attendance/employee-records")
     * @Get("time/attendance/employee-records/{date}")
     *
     * @param null $date
     * @return \Illuminate\View\View
     */
    public function index($date = null)
    {
        if (is_null($date))
        {
            $date = Carbon::now()->toDateString();
        }
        $this->data['date'] = $date;
        $this->data['employees'] = Employee::whereNotNull('face_id')->where('id', '>', 1)->with('timelogs')->take(2)->get();

        $this->data['pageTitle'] = 'Employee Records';

        return $this->template('pages.time.attendance.employee-records');
    }

}

<?php namespace HRis\Http\Controllers\Time\Attendance;

use HRis\Eloquent\Employee;
use HRis\Eloquent\TimeLog;
use HRis\Http\Controllers\Controller;

/**
 * @Middleware("auth")
 */
class EmployeeRecordsController extends Controller {

    /**
     * Show the application dashboard to the user.
     *
     * @Get("time/attendance/employee-records")
     */
    public function index()
    {
        $this->data['employees'] = Employee::whereNotNull('face_id')->with('timelogs')->take(8)->get();

        $this->data['pageTitle'] = 'Employee Records';

        return $this->template('pages.time.attendance.employee-records');
    }

}

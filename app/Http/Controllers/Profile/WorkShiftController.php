<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Controllers\Profile;

use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\CustomFieldSection;
use HRis\Eloquent\Employee;
use HRis\Eloquent\EmployeeWorkShift;
use HRis\Eloquent\Navlink;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\WorkShiftRequest;
use Input;

/**
 * Class WorkShiftController.
 *
 * @Middleware("auth")
 */
class WorkShiftController extends Controller
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var EmployeeWorkShift
     */
    protected $employee_work_shift;

    /**
     * @param Sentinel          $auth
     * @param Employee          $employee
     * @param EmployeeWorkShift $employee_work_shift
     *
     * @author Bertrand Kintanar
     */
    public function __construct(Sentinel $auth, Employee $employee, EmployeeWorkShift $employee_work_shift)
    {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->employee_work_shift = $employee_work_shift;

        $profile_details_id = Navlink::whereName('Work Shifts')->pluck('id');
        $this->data['custom_field_sections'] = CustomFieldSection::whereScreenId($profile_details_id)->get();
    }

    /**
     * Show the Profile - Work Shift.
     *
     * @Get("profile/work-shifts")
     * @Get("pim/employee-list/{id}/work-shifts")
     *
     * @param WorkShiftRequest $request
     * @param null             $employee_id
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar
     */
    public function index(WorkShiftRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        $this->data['employee'] = $employee;
        $this->data['workshift_history'] = $employee->employeeWorkShift;

        $this->data['pim'] = $request->is('*pim/*') ?: false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Job Details' : 'My Job Details';

        return $this->template('pages.profile.workshift.view');
    }

    /**
     * Updates the Profile - Work Shift.
     *
     * @Patch("profile/work-shifts")
     * @Patch("pim/employee-list/{id}/work-shifts")
     *
     * @param WorkShiftRequest $request
     *
     * @return Response
     *
     * @author Bertrand Kintanar
     */
    public function update(WorkShiftRequest $request)
    {
        $employee_id = $request->get('employee_id');

        $employee_work_shift = $this->employee_work_shift;
        $work_shift_fillables = $employee_work_shift->getFillable();
        $current_work_shift = $employee_work_shift->getCurrentEmployeeWorkShift($work_shift_fillables, $employee_id);
        $work_shift_request_fields = $request->only($work_shift_fillables);

        if ($current_work_shift != $work_shift_request_fields) {
            $work_shift_request_fields['effective_date'] = Carbon::now()->toDateString();
            $employee_work_shift->create($work_shift_request_fields);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     *
     * @author Bertrand Kintanar
     */
    public function destroy($id)
    {
        //
    }
}

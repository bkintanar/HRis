<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\CustomFieldSection;
use HRis\Eloquent\Employee;
use HRis\Eloquent\EmployeeWorkShift;
use HRis\Eloquent\JobHistory;
use HRis\Eloquent\Navlink;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\JobRequest;
use Illuminate\Support\Facades\Request;
use Input;

/**
 * Class JobController.
 *
 * @Middleware("auth")
 */
class JobController extends Controller
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var JobHistory
     */
    protected $job_history;

    /**
     * @param Sentinel          $auth
     * @param Employee          $employee
     * @param JobHistory        $job_history
     * @param EmployeeWorkShift $employee_work_shift
     *
     * @author Bertrand Kintanar
     */
    public function __construct(
        Sentinel $auth,
        Employee $employee,
        JobHistory $job_history,
        EmployeeWorkShift $employee_work_shift
    ) {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->job_history = $job_history;
        $this->employee_work_shift = $employee_work_shift;

        $profile_details_id = Navlink::whereName('Job')->pluck('id');
        $this->data['custom_field_sections'] = CustomFieldSection::whereScreenId($profile_details_id)->get();
    }

    /**
     * Show the Profile - Job.
     *
     * @Get("profile/job")
     * @Get("pim/employee-list/{id}/job")
     *
     * @param JobRequest $request
     * @param null       $employee_id
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar
     */
    public function index(JobRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        $this->data['employee'] = $employee;

        $job_histories = $employee->orderedJobHistories();

        $this->data['pim'] = $request->is('*pim/*') ?: false;
        $this->data['table'] = $this->setupDataTable($job_histories);
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Job Details' : 'My Job Details';

        return $this->template('pages.profile.job.view');
    }

    /**
     * @param $job_histories
     *
     * @return array
     *
     * @author Bertrand Kintanar
     */
    public function setupDataTable($job_histories)
    {
        $table = [];

        $table['title'] = 'Job History';
        $table['permission'] = str_replace('pim', 'profile', Request::segment(1)).'.job-histories';
        $table['headers'] = ['Job Title', 'Department', 'Effective Date', 'Employment Status', 'Location', 'Comments'];
        $table['model'] = ['singular' => 'job_history', 'plural' => 'job_histories', 'dashed' => 'job-histories'];
        $table['items'] = $job_histories;

        return $table;
    }

    /**
     * Updates the Profile - Job.
     *
     * @Patch("profile/job")
     * @Patch("pim/employee-list/{id}/job")
     *
     * @param JobRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function update(JobRequest $request)
    {
        $employee_id = $request->get('employee_id');

        $job_history = $this->job_history;
        $job_history_fillables = $job_history->getFillable();
        $current_employee_job = $job_history->getCurrentEmployeeJob($job_history_fillables, $employee_id);
        $job_request_fields = $request->only($job_history_fillables);

        if ($current_employee_job != $job_request_fields) {
            $job_history->create($job_request_fields);
        }

        $this->employee->whereId($employee_id)
            ->update($request->only('joined_date', 'probation_end_date', 'permanency_date'));

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}

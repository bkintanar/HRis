<?php namespace HRis\Http\Controllers\PIM;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\PIM\PIMRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

/**
 * @Middleware("auth")
 */
class EmployeeListController extends Controller {

    protected $user;

    public function __construct(Sentry $auth, Employee $employee)
    {
        parent::__construct($auth);

        $this->employee = $employee;
    }

    /**
     * Show the PIM - Employee List
     *
     * @Get("pim/employee-list")
     * @param PIMRequest $request
     * @return \Illuminate\View\View
     */
    public function index(PIMRequest $request)
    {
        $this->data['employees'] = $this->employee->with('user', 'jobTitle', 'employmentStatus')->get();
        $this->data['pim'] = true;
        $this->data['pageTitle'] = 'Employee Information';

        return $this->template('pages.pim.employee-list.view');
    }


    /**
     * Show the PIM - Employee with the given Id.
     *
     * @Get("pim/employee-list/{id}")
     * @param $employee_id
     * @return
     */
    public function viewEmployee($employee_id)
    {
        $employee = $this->employee->whereId($employee_id)->first();

        if ($employee)
        {
            return Redirect::to(Request::path() . '/personal-details');
        }
        else
        {
            // TODO: Show Employee ID not found error
            die('not found');
        }
    }

    /**
     * Show the PIM - Index - redirects to employee-list
     *
     * @Get("pim")
     * @param PIMRequest $request
     * @return
     */
    public function pim(PIMRequest $request)
    {
        return Redirect::to($request->path() . '/employee-list');
    }
}
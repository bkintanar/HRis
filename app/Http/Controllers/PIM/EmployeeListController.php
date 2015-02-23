<?php namespace HRis\Http\Controllers\PIM;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Eloquent\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\PIM\PIMRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

/**
 * @Middleware("auth")
 */
class EmployeeListController extends Controller {

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @param Sentry $auth
     * @param Employee $employee
     */
    public function __construct(Sentry $auth, Employee $employee)
    {
        parent::__construct($auth);

        $this->employee = $employee;
    }

    /**
     * Show the PIM - Employee List
     *
     * @Get("pim/employee-list")
     *
     * @param PIMRequest $request
     *
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
     */
    public function show($employee_id)
    {
        $employee = $this->employee->whereId($employee_id)->first();

        if ($employee)
        {
            return Redirect::to(Request::path() . '/personal-details');
        }

        return Response::make(View::make('errors.404'), 404);
    }

    /**
     * Show the PIM - Index - redirects to pim/employee-list
     *
     * @Get("pim")
     * @param PIMRequest $request
     */
    public function pim(PIMRequest $request)
    {
        return Redirect::to($request->path() . '/employee-list');
    }
}

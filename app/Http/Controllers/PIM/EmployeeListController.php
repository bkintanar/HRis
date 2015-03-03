<?php namespace HRis\Http\Controllers\PIM;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Eloquent\Employee;
use HRis\Eloquent\EmployeeSalaryComponent;
use HRis\Eloquent\SalaryComponent;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\PIM\PIMRequest;
use HRis\Services\Pagination;
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
     * @param EmployeeSalaryComponent $employee_salary_component
     * @param SalaryComponent $salary_component
     * @param Pagination $pagination
     */
    public function __construct(
        Sentry $auth,
        Employee $employee,
        EmployeeSalaryComponent $employee_salary_component,
        SalaryComponent $salary_component,
        Pagination $pagination)
    {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->employee_salary_component = $employee_salary_component;
        $this->salary_component = $salary_component;
        $this->pagination = $pagination;
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
        $sort = 'id';
        if ($request->get('sort'))
        {
            $sort = $request->get('sort');
        }

        $employees = $this->employee->getEmployeeList(true, $sort);

        $this->data['employees'] = $employees;
        $this->data['path'] = $request->path();
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

    /**
     * Adding new user - Employee.
     *
     * @Post("pim/employee-list")
     *
     * @param PIMRequest $request
     */
    public function store(PIMRequest $request)
    {
        try
        {
            $new_employee = $this->employee->create($request->all());
            $components = $this->salary_component->all();
            foreach ($components as $value)
            {
                $salary_components = ['employee_id' => $new_employee->id, 'component_id' => $value->id, 'value' => 0];
                $this->employee_salary_component->create($salary_components);
            }
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
    }
}

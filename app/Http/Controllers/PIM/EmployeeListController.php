<?php

namespace HRis\Http\Controllers\PIM;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\Employee;
use HRis\Eloquent\EmployeeSalaryComponent;
use HRis\Eloquent\SalaryComponent;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\PIM\PIMRequest;
use HRis\Services\Pagination;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

/**
 * Class EmployeeListController
 * @package HRis\Http\Controllers\PIM
 *
 * @Middleware("auth")
 */
class EmployeeListController extends Controller
{

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var EmployeeSalaryComponent
     */
    protected $employee_salary_component;

    /**
     * @var Pagination
     */
    protected $pagination;

    /**
     * @var SalaryComponent
     */
    protected $salary_component;

    /**
     * @var
     */
    private $columns;

    /**
     * @param Sentinel $auth
     * @param Employee $employee
     * @param EmployeeSalaryComponent $employee_salary_component
     * @param SalaryComponent $salary_component
     * @param Pagination $pagination
     */
    public function __construct(
        Sentinel $auth,
        Employee $employee,
        EmployeeSalaryComponent $employee_salary_component,
        SalaryComponent $salary_component,
        Pagination $pagination
    ) {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->employee_salary_component = $employee_salary_component;
        $this->salary_component = $salary_component;
        $this->pagination = $pagination;
        $this->employee_id_prefix = Config::get('company.employee_id_prefix');

        $this->setColumns();
    }

    /**
     *
     */
    private function setColumns()
    {
        $this->columns = [
            'employees.id'             => 'Id',
            'employees.first_name'     => 'First Name',
            'employees.last_name'      => 'Last Name',
            'job_titles.name'          => 'Job Title',
            'employment_statuses.name' => 'Employment Status'
        ];
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
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'employees.id';
        $direction = $request->get('direction') != '' ? $request->get('direction') : 'asc';

        $employees = $this->employee->getEmployeeList(true, $sort, $direction);

        $this->data['employees'] = $employees;
        $this->data['employee_id_prefix'] = $this->employee_id_prefix;
        $this->data['settings'] = ['path' => $request->path(), 'sort' => $sort, 'direction' => $direction];
        $this->data['columns'] = $this->getColumns();
        $this->data['pim'] = true;
        $this->data['pageTitle'] = 'Employee Information';

        return $this->template('pages.pim.employee-list.view');
    }

    /**
     * @return mixed
     */
    private function getColumns()
    {
        return $this->columns;
    }

    /**
     * Show the PIM - Index - redirects to pim/employee-list
     *
     * @Get("pim")
     * @param PIMRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pim(PIMRequest $request)
    {
        return redirect()->to($request->path() . '/employee-list');
    }

    /**
     * Show the PIM - Employee with the given Id.
     *
     * @Get("pim/employee-list/{id}")
     * @param $employee_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show($employee_id)
    {
        $employee = $this->employee->whereId($employee_id)->first();

        if ($employee) {

            return redirect()->to(Request::path() . '/personal-details');
        }

        return response()->make(view()->make('errors.404'), 404);
    }

    /**
     * Adding new user - Employee.
     *
     * @Post("pim/employee-list")
     *
     * @param PIMRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PIMRequest $request)
    {
        try {

            $new_employee = $this->employee->create($request->all());
            $components = $this->salary_component->all();

            foreach ($components as $value) {

                $salary_components = ['employee_id' => $new_employee->id, 'component_id' => $value->id, 'value' => 0];
                $this->employee_salary_component->create($salary_components);
            }
        } catch (Exception $e) {

            return redirect()->to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
    }
}

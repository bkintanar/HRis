<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

namespace HRis\Api\Controllers\PIM;

use Exception;
use HRis\Api\Requests\PIM\PIMRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Irradiate\Api\Controllers\BaseController;
use Irradiate\Eloquent\Employee;
use Irradiate\Eloquent\EmployeeSalaryComponent;
use Irradiate\Eloquent\SalaryComponent;
use Symfony\Component\HttpFoundation\Response;

class EmployeeListController extends BaseController
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
     * @var SalaryComponent
     */
    protected $salary_component;

    /**
     * @param Employee                $employee
     * @param EmployeeSalaryComponent $employee_salary_component
     * @param SalaryComponent         $salary_component
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Employee $employee, EmployeeSalaryComponent $employee_salary_component, SalaryComponent $salary_component)
    {
        $this->employee = $employee;
        $this->employee_salary_component = $employee_salary_component;
        $this->salary_component = $salary_component;
        $this->employee_id_prefix = Config::get('company.employee_id_prefix');

        $this->setColumns();
    }

    /**
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private function setColumns()
    {
        $this->columns = [
            'employees.id'             => 'Id',
            'employees.first_name'     => 'First Name',
            'employees.last_name'      => 'Last Name',
            'job_titles.name'          => 'Job Title',
            'employment_statuses.name' => 'Status',
        ];
    }

    /**
     * Show the PIM - Employee List.
     *
     * @param PIMRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index(PIMRequest $request)
    {
        $employees = $this->employee->getEmployeeList(false, $request->sort(), $request->direction())->get();

        return $this->responseAPI(Response::HTTP_OK, SUCCESS_RETRIEVE_MESSAGE, compact('employees'));
    }

    /**
     * Show the PIM - Employee with the given Id.
     *
     * @param $employee_id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function show($employee_id)
    {
        $employee = $this->employee->whereId($employee_id)->first();

        if ($employee) {
            return redirect()->to(Request::path().'/personal-details');
        }

        return response()->make(view()->make('errors.404'), 404);
    }

    /**
     * Adding new user - Employee.
     *
     * @param PIMRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
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

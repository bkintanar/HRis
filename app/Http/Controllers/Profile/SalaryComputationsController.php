<?php

namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\Employee;
use HRis\Eloquent\EmployeeSalaryComponents;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests;
use HRis\Http\Requests\Profile\SalaryRequest;
use HRis\Services\Salary;

/**
 * Class SalaryComputationsController
 * @package HRis\Http\Controllers\Profile
 *
 * @Middleware("auth")
 */
class SalaryComputationsController extends Controller
{

    /**
     * @param Sentinel $auth
     * @param Employee $employee
     * @param EmployeeSalaryComponent $employee_salary_component
     * @param Salary $salary_services
     */
    public function __construct(
        Sentinel $auth,
        Employee $employee,
        EmployeeSalaryComponent $employee_salary_component,
        Salary $salary_services
    ) {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->employee_salary_components = $employee_salary_components;
        $this->salary_services = $salary_services;
    }

    /**
     * Display a listing of the resource.
     *
     * @Get("profile/salary")
     * @Get("pim/employee-list/{id}/salary")
     *
     * @param SalaryRequest $request
     * @return Response
     */
    public function salary(SalaryRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeSalaryDetails($employee_id, $this->logged_user->employee->id);

        $salary = $this->salary_services->getSalaryDetails($employee);

        $this->data['employee'] = $employee;
        $this->data['tax'] = $salary['total_tax'];
        $this->data['salary'] = $salary['salary'];

        $this->data['disabled'] = 'disabled';
        $this->data['pim'] = $request->is('*pim/*') ? true : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Salary Details' : 'My Salary Details';

        return $this->template('pages.profile.salary.view');
    }

    /**
     * Show the profile contact details form.
     *
     * @Get("profile/salary/edit")
     * @Get("pim/employee-list/{id}/salary/edit")
     *
     * @param SalaryRequest $request
     * @param null $employee_id
     * @return \Illuminate\View\View
     */
    public function showSalaryEditForm(SalaryRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeSalaryDetails($employee_id, $this->logged_user->employee->id);

        $employee_status = 'ME_S';
        $dependents = count($employee->dependents);
        if ($dependents)
        {
            $employee_status = 'ME' . $dependents . '_S' . $dependents;
        }

        $this->data['employee'] = $employee;
        $this->data['tax'] = $salary['total_tax'];
        $this->data['salary'] = $salary['salary'];
        $this->data['tax_status'] = $salary['employee_status'];

        $this->data['disabled'] = '';
        $this->data['pim'] = $request->is('*pim/*') ? true : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Salary Details' : 'My Salary Details';

        return $this->template('pages.profile.salary.edit');

    }

    /**
     * Updates the Profile - Salary.
     *
     * @Patch("profile/salary")
     * @Patch("pim/employee-list/{id}/salary")
     *
     * @param SalaryRequest $request
     */
    public function update(SalaryRequest $request)
    {
        $id = $request->get('employee_id');
        $fields = $request->except('_method', '_token', 'employee_id');

        foreach ($fields as $value) {
            $value['employee_id'] = $id;
            if ($value['effective_date'] == 0) {
                $value['effective_date'] = date('Y-m-d');
            }

            try {
                $employee_salary_component = $this->employee_salary_component->getCurrentComponentValue($id,
                    $value['component_id']);
                if ($employee_salary_component->value != 0 && $employee_salary_component->value != $value['value']) {
                    $this->employee_salary_component->create($value);
                } else {
                    $employee_salary_component->value = $value['value'];
                    $employee_salary_component->effective_date = $value['effective_date'];
                    $employee_salary_component->save();
                }
            } catch (Exception $e) {
                return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
            }
        }

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);

    }

}

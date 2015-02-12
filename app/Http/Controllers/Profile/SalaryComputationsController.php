<?php namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Http\Requests;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\SalaryRequest;
use HRis\Employee;
use HRis\EmployeeSalaryComponents;
use HRis\Services\Salary;

use Illuminate\Http\Request;

class SalaryComputationsController extends Controller {

    public function __construct(Sentry $auth, Employee $employee, EmployeeSalaryComponents $employee_salary_components, Salary $salary_services)
    {
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
        $employee = $this->employee->getEmployeeSalarydetails($employee_id, $this->loggedUser->id);

        $salary = $this->salary_services->getSalaryDetails($employee);

        $this->data['employee'] = $employee;
        $this->data['tax'] = $salary['totalTax'];

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
        $employee = $this->employee->getEmployeeSalarydetails($employee_id, $this->loggedUser->id);

        $salary = $this->salary_services->getSalaryDetails($employee);

        $this->data['employee'] = $employee;
        $this->data['tax'] = $salary['totalTax'];
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
        $id = $request->get('id');
        $fields = $request->except('id', '_method', '_token', 'user', 'tax');

        foreach($fields as $value)
        {
            $value['employee_id'] = $id;
            if($value['effective_date'] == 0)
            {
                $value['effective_date'] = date('Y-m-d');
            }

            try
            {
                $this->employee_salary_components->create($value);
            } catch (Exception $e)
            {
                return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
            }
        }
        return \Redirect::to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);

    }

}

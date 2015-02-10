<?php namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Http\Requests;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\SalaryRequest;
use HRis\Employee;
use HRis\SSSContributions;
use HRis\SalaryComponents;
use HRis\TaxComputations;
use HRis\Dependent;

use Illuminate\Http\Request;

class SalaryComputationsController extends Controller {

    public function __construct(Sentry $auth, Employee $employee, TaxComputations $tax_computations, Dependent $dependent)
    {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->tax_computations = $tax_computations;
        $this->dependent = $dependent;
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
        $employeeComponents = $employee->employeeSalaryComponents;
        $deductions = 0;

        foreach($employeeComponents as $key => $employeeComponent)
        {
            if($employeeComponent->component_id == 1)
            {
                $semiMonthly = $employeeComponents[$key]->value / 2;
                $employeeComponents[$key]->value = $semiMonthly;
            }
            if($employeeComponent->component_id == 2)
            {
                if($employeeComponents[$key]->value == 0)
                {
                    $getSSS = SSSContributions::where('range_compensation_from', '<=', $semiMonthly)
                        ->orderBy('range_compensation_from', 'desc')
                        ->first();
                    $employeeComponents[$key]->value = $getSSS->sss_ee;
                }
            }
            if($employeeComponent->salaryComponent->type == 2)
            {
                $deductions += $employeeComponent->value;
            }
        }

        $status = 'ME_S';
        if (count($employee->dependents))
        {
            $status = 'ME' . count($employee->dependents) . '_S' . count($employee->dependents);
        }

        $taxableSalary = $semiMonthly - $deductions;
        $taxes = $this->tax_computations->getTaxRate($status, $taxableSalary);

        $over = 0;
        if ($taxableSalary > $taxes->$status)
        {
            $over = $taxableSalary - $taxes->$status;
        }
        $totalTax = $taxes->exemption + ($over * $taxes->percentage_over);

        $this->data['employee'] = $employee;
        $this->data['tax'] = round($totalTax, 2);

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

        $this->data['employee'] = $employee;

        $this->data['disabled'] = '';
        $this->data['pim'] = $request->is('*pim/*') ? true : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Salary Details' : 'My Salary Details';

        return $this->template('pages.profile.salary.edit');
    }

}

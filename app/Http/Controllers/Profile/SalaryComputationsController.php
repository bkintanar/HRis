<?php namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Http\Requests;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\SalaryRequest;
use HRis\Employee;
use HRis\Sss;
use HRis\EmployeeSalaryComponents;
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
        $employee = $this->employee->whereEmployeeId($employee_id)->with('employeeSalaryComponents')->first();
//        $semiMonthly = $employee->employeeSalary->salary / 2;
//        $contributions = $employee->employeeContributions->first();


//        if (!$contributions->SSS)
//        {
//            $getSSS = Sss::where('range_compensation_from', '<=', $semiMonthly)->orderBy('range_compensation_from', 'desc')->first();
//            $contributions->SSS = $getSSS->sss_ee;
//        }
//
//        $status = 'ME_S';
//        if (count($employee->dependents))
//        {
//            $status = 'ME' . count($employee->dependents) . '_S' . count($employee->dependents);
//        }
//
//        $deductions = $contributions->SSS + $contributions->PhilHealth + $contributions->HDMF;
//        $taxableSalary = $semiMonthly - $deductions;
//        $taxes = $this->tax_computations->getTaxRate($status, $taxableSalary);
//
//        $over = 0;
//        if ($taxableSalary > $taxes->$status)
//        {
//            $over = $taxableSalary - $taxes->$status;
//        }
//        $totalTax = $taxes->exemption + ($over * $taxes->percentage_over);
//        $finalSalary = $taxableSalary - $totalTax;
//
//        echo $taxableSalary;
//        echo '<br/>';
//        echo '<br/>';
//        echo 'Total Ded: ' . $deductions . ' (' . $contributions->SSS . ' ' . $contributions->PhilHealth . ' ' . $contributions->HDMF . ')';
//        echo '<br/>';
//        echo 'Total Tax: ' . round($totalTax, 2);
//        echo '<br/>';
//        echo 'Salary: ' . round($finalSalary, 2);
//
//        die;
//
//        $this->data['employee'] = $employee;
//        $this->data['salary'] = $semiMonthly;
//

        dd($employee);

        $this->data['employee'] = $employee;

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
        $employee = $this->employee->whereEmployeeId($employee_id)->with('employeeSalary', 'dependents', 'employeeContributions')->first();

        $this->data['employee'] = $employee;

        $this->data['disabled'] = '';
        $this->data['pim'] = $request->is('*pim/*') ? true : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Salary Details' : 'My Salary Details';

        return $this->template('pages.profile.salary.edit');
    }

}

<?php namespace HRis\Services;

use Config;
use HRis\Eloquent\Dependent;
use HRis\Eloquent\SalaryComponents;
use HRis\Eloquent\SSSContributions;
use HRis\Eloquent\TaxComputations;

class Salary {

    public function __construct(TaxComputations $tax_computations, Dependent $dependent, SSSContributions $sss_contribution, SalaryComponents $salary_components)
    {
        $this->tax_computations = $tax_computations;
        $this->dependent = $dependent;
        $this->sss_contribution = $sss_contribution;
        $this->salary_components = $salary_components;
    }

    function getSalaryDetails($employee)
    {
        $mode = Config::get('salary.semi_monthly');
        $employeeComponents = $employee->employeeSalaryComponents;
        $componentsIds = $this->salary_components->getSalaryAndSSS();
        $deductions = 0;

        foreach ($employeeComponents as $employeeComponent)
        {
            if ($employeeComponent->component_id == $componentsIds['monthlyBasic'])
            {
                $semiMonthly = $employeeComponent->value / $mode;
            }
            if ($employeeComponent->component_id == $componentsIds['SSS'])
            {
                if ($employeeComponent->value == 0)
                {
                    $getSSS = $this->sss_contribution->where('range_compensation_from', '<=', $semiMonthly)
                        ->orderBy('range_compensation_from', 'desc')
                        ->first();
                    $employeeComponent->value = $getSSS->sss_ee;
                }
            }
            if ($employeeComponent->salaryComponent->type == 2)
            {
                $deductions += $employeeComponent->value;
            }
        }

        $employee_status = 'ME_S';
        $dependents = count($employee->dependents);
        if ($dependents)
        {
            $employee_status = 'ME' . $dependents . '_S' . $dependents;
        }

        $taxableSalary = $semiMonthly - $deductions;
        $taxes = $this->tax_computations->getTaxRate($employee_status, $taxableSalary);

        $over = 0;
        if ($taxableSalary > $taxes->$employee_status)
        {
            $over = $taxableSalary - $taxes->$employee_status;
        }
        $totalTax = $taxes->exemption + ($over * $taxes->percentage_over);

        return ['totalTax' => round($totalTax, 2), 'employee_status' => $employee_status];
    }

} 
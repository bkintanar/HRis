<?php namespace HRis\Services;

use HRis\SSSContributions;
use HRis\TaxComputations;
use HRis\Dependent;

class Salary {

    public function __construct(TaxComputations $tax_computations, Dependent $dependent)
    {
        $this->tax_computations = $tax_computations;
        $this->dependent = $dependent;
    }

    function getSalaryDetails($employee)
    {
        $mode = \Config::get('salary.semi_monthly');
        $employeeComponents = $employee->employeeSalaryComponents;
        $deductions = 0;

        foreach ($employeeComponents as $key => $employeeComponent)
        {
            if ($employeeComponent->component_id == 1)
            {
                $semiMonthly = $employeeComponent->value / $mode;
            }
            if ($employeeComponent->component_id == 2)
            {
                if ($employeeComponent->value == 0)
                {
                    $getSSS = SSSContributions::where('range_compensation_from', '<=', $semiMonthly)
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
<?php namespace HRis\Services;

use Config;
use HRis\Eloquent\Dependent;
use HRis\Eloquent\EmployeeSalaryComponent;
use HRis\Eloquent\SalaryComponent;
use HRis\Eloquent\SSSContribution;
use HRis\Eloquent\TaxComputation;

/**
 * Class Salary
 * @package HRis\Services
 */
class Salary {

    /**
     * @param TaxComputation $tax_computation
     * @param Dependent $dependent
     * @param SSSContribution $sss_contribution
     * @param SalaryComponent $salary_component
     * @param EmployeeSalaryComponent $employee_salary_component
     */
    public function __construct(TaxComputation $tax_computation, Dependent $dependent, SSSContribution $sss_contribution, SalaryComponent $salary_component, EmployeeSalaryComponent $employee_salary_component)
    {
        $this->tax_computation = $tax_computation;
        $this->dependent = $dependent;
        $this->sss_contribution = $sss_contribution;
        $this->salary_component = $salary_component;
        $this->employee_salary_component = $employee_salary_component;
    }

    /**
     * @param $employee
     * @return array
     */
    function getSalaryDetails($employee)
    {
        $mode = Config::get('salary.semi_monthly');
        $employee_salary_components = $employee->employeeSalaryComponent;
        $component_ids = $this->salary_component->getSalaryAndSSS();
        $deductions = 0;
        $salary = 0;

        foreach ($employee_salary_components as $employee_salary_component)
        {
            if ($employee_salary_component->component_id == $component_ids['monthlyBasic'])
            {
                $salary = $employee_salary_component->value / $mode;
            }
            else if ($employee_salary_component->component_id == $component_ids['SSS'] && $employee_salary_component->value == 0 && $salary != 0)
            {
                $getSSS = $this->sss_contribution->where('range_compensation_from', '<=', $salary)
                    ->orderBy('range_compensation_from', 'desc')
                    ->first();
                $employee_salary_component->value = $getSSS->sss_ee;
            }
        }

        $employee_status = 'ME_S';
        $dependents = count($employee->dependents);
        if ($dependents)
        {
            if($dependents>4){
                $dependents = 4;
            }
            $employee_status = 'ME' . $dependents . '_S' . $dependents;
        }

        $taxableSalary = $salary - $deductions;
        $taxes = $this->tax_computation->getTaxRate($employee_status, $taxableSalary);

        $over = 0;
        $totalTax = 0;
        if ($taxes)
        {
            if ($taxableSalary > $taxes->$employee_status)
            {
                $over = $taxableSalary - $taxes->$employee_status;
            }

            $totalTax = $taxes->exemption + ($over * $taxes->percentage_over);
        }

        return ['total_tax' => round($totalTax, 2), 'employee_status' => $employee_status, 'salary' => $salary];

    }

}

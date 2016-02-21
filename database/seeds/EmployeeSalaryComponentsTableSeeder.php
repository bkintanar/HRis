<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Seeder;

class EmployeeSalaryComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @author Bertrand Kintanar
     */
    public function run()
    {
        DB::table('employee_salary_components')->truncate();

        DB::table('employee_salary_components')->insert(
            [
                [
                    'id'             => 1,
                    'employee_id'    => 11,
                    'component_id'   => 1,
                    'value'          => 25000.00,
                    'effective_date' => '2013-10-31',
                ],
                [
                    'id'             => 2,
                    'employee_id'    => 11,
                    'component_id'   => 2,
                    'value'          => 290.65,
                    'effective_date' => '2013-10-31',
                ],
                [
                    'id'             => 3,
                    'employee_id'    => 11,
                    'component_id'   => 3,
                    'value'          => 168.75,
                    'effective_date' => '2013-10-31',
                ],
                [
                    'id'             => 4,
                    'employee_id'    => 11,
                    'component_id'   => 4,
                    'value'          => 50.00,
                    'effective_date' => '2013-10-31',
                ],
                [
                    'id'             => 5,
                    'employee_id'    => 17,
                    'component_id'   => 1,
                    'value'          => 25000.00,
                    'effective_date' => '2013-10-31',
                ],
                [
                    'id'             => 6,
                    'employee_id'    => 17,
                    'component_id'   => 2,
                    'value'          => 290.65,
                    'effective_date' => '2013-10-31',
                ],
                [
                    'id'             => 7,
                    'employee_id'    => 17,
                    'component_id'   => 3,
                    'value'          => 168.75,
                    'effective_date' => '2013-10-31',
                ],
                [
                    'id'             => 8,
                    'employee_id'    => 17,
                    'component_id'   => 4,
                    'value'          => 50.00,
                    'effective_date' => '2013-10-31',
                ],
            ]
        );
    }
}

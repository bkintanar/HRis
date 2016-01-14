<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
use HRis\Api\Eloquent\Employee;
use HRis\Api\Eloquent\User;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
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
        DB::table('employees')->delete();

        foreach ($this->employees() as $employee) {
            Employee::create($employee);
        }
    }

    /**
     * Employee's data.
     *
     * @return array
     *
     * @author Harlequin Doyon
     */
    public function employees()
    {
        return [
            [
                'employee_id'         => 'HRis-0001',
                'user_id'             => User::whereEmail('bertrand.kintanar@gmail.com')->first()->id,
                'marital_status_id'   => 2,
                'nationality_id'      => 62,
                'first_name'          => 'Bertrand',
                'middle_name'         => 'Son',
                'last_name'           => 'Kintanar',
                'gender'              => 'M',
                'address_1'           => 'Judge Pedro Son Compound',
                'address_2'           => 'Miñoza St. Talamban',
                'address_city_id'     => 439,
                'address_province_id' => 25,
                'address_country_id'  => 185,
                'address_postal_code' => 6000,
                'home_phone'          => '032 520 2160',
                'mobile_phone'        => '0949 704 7136',
                'work_email'          => 'bertrand@idearobin.com',
                'birth_date'          => '1985-10-31',
                'social_security'     => '07-2480504-4',
                'tax_identification'  => '278-992-354',
                'philhealth'          => '12-050792495-1',
                'hdmf_pagibig'        => '1210 2113 5039',
            ],
            [
                'employee_id'         => 'HRis-0002',
                'user_id'             => 2,
                'marital_status_id'   => 1,
                'nationality_id'      => 62,
                'first_name'          => 'Gabriel',
                'last_name'           => 'Ceniza',
                'gender'              => 'M',
            ],
            [
                'employee_id'         => 'HRis-0003',
                'user_id'             => 3,
                'marital_status_id'   => 1,
                'nationality_id'      => 62,
                'first_name'          => 'Harlequin',
                'last_name'           => 'Doyon',
                'middle_name'         => 'Bagaipo',
                'gender'              => 'M',
            ],
        ];
    }
}

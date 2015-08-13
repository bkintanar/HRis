<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @author Bertrand Kintanar
     */
    public function run()
    {
        DB::table('employees')->delete();

        DB::table('employees')->insert(
            [
                [
                    'id'                  => 1,
                    'employee_id' => 'HRis-0001',
                    'user_id'             => 1,
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
                    'work_email'          => 'bert.nst@gmail.com',
                    'social_security'     => null,
                    'tax_identification'  => null,
                    'philhealth'          => null,
                    'hdmf_pagibig'        => null,
                    'mid_rtn'             => null,
                    'birth_date'          => '1985-10-31',
                    'remarks'             => null,
                    'joined_date'         => null,
                    'probation_end_date'  => null,
                    'permanency_date'     => null,
                    'resign_date'         => null
                ],
                [
                    'id'                  => 2,
                    'employee_id' => 'HRis-0002',
                    'user_id'             => 2,
                    'marital_status_id'   => 1,
                    'nationality_id'      => 62,
                    'first_name'          => 'Gabriel',
                    'middle_name'         => null,
                    'last_name'           => 'Ceniza',
                    'gender'              => 'M',
                    'address_1'           => null,
                    'address_2'           => null,
                    'address_city_id'     => null,
                    'address_province_id' => null,
                    'address_country_id'  => null,
                    'address_postal_code' => null,
                    'home_phone'          => null,
                    'mobile_phone'        => null,
                    'work_email'          => null,
                    'social_security'     => null,
                    'tax_identification'  => null,
                    'philhealth'          => null,
                    'hdmf_pagibig'        => null,
                    'mid_rtn'             => null,
                    'birth_date'          => null,
                    'remarks'             => null,
                    'joined_date'         => null,
                    'probation_end_date'  => null,
                    'permanency_date'     => null,
                    'resign_date'         => null
                ],
            ]
        );
    }
}

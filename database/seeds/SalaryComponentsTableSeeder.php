<?php

use Illuminate\Database\Seeder;

class SalaryComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('salary_components')->truncate();

        DB::table('salary_components')->insert(
            [
                [
                    'id'                    => 1,
                    'name'                  => 'Monthly Basic',
                    'type'                  => 1,
                    'part_of_total_payable' => 1,
                    'cost_to_company'       => 1
                ],
                [
                    'id'                    => 2,
                    'name'                  => 'SSS',
                    'type'                  => 2,
                    'part_of_total_payable' => 1,
                    'cost_to_company'       => 0
                ],
                [
                    'id'                    => 3,
                    'name'                  => 'PhilHealth',
                    'type'                  => 2,
                    'part_of_total_payable' => 1,
                    'cost_to_company'       => 0
                ],
                [
                    'id'                    => 4,
                    'name'                  => 'HDMF',
                    'type'                  => 2,
                    'part_of_total_payable' => 1,
                    'cost_to_company'       => 0
                ]

            ]
        );
    }
}

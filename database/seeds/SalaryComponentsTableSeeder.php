<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */
 
use Illuminate\Database\Seeder;

class SalaryComponentsTableSeeder extends Seeder
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
        DB::table('salary_components')->truncate();

        DB::table('salary_components')->insert(
            [
                [
                    'id'                    => 1,
                    'name'                  => 'Monthly Basic',
                    'type'                  => 1,
                    'part_of_total_payable' => 1,
                    'cost_to_company'       => 1,
                ],
                [
                    'id'                    => 2,
                    'name'                  => 'SSS',
                    'type'                  => 2,
                    'part_of_total_payable' => 1,
                    'cost_to_company'       => 0,
                ],
                [
                    'id'                    => 3,
                    'name'                  => 'PhilHealth',
                    'type'                  => 2,
                    'part_of_total_payable' => 1,
                    'cost_to_company'       => 0,
                ],
                [
                    'id'                    => 4,
                    'name'                  => 'HDMF',
                    'type'                  => 2,
                    'part_of_total_payable' => 1,
                    'cost_to_company'       => 0,
                ],

            ]
        );
    }
}

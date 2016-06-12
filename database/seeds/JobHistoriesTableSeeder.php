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

class JobHistoriesTableSeeder extends Seeder
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
        DB::table('job_histories')->delete();

        DB::table('job_histories')->insert(
            [
                [
                    'id'                   => 1,
                    'employee_id'          => 1,
                    'job_title_id'         => 3,
                    'department_id'        => 3,
                    'employment_status_id' => 2,
                    'location_id'          => 1,
                    'effective_date'       => null,
                    'comments'             => null,
                ],
                [
                    'id'                   => 2,
                    'employee_id'          => 2,
                    'job_title_id'         => 10,
                    'department_id'        => 3,
                    'employment_status_id' => 2,
                    'location_id'          => 1,
                    'effective_date'       => null,
                    'comments'             => null,
                ],
                [
                    'id'                   => 3,
                    'employee_id'          => 3,
                    'job_title_id'         => 13,
                    'department_id'        => 3,
                    'employment_status_id' => 1,
                    'location_id'          => 1,
                    'effective_date'       => null,
                    'comments'             => null,
                ],
            ]
        );
    }
}

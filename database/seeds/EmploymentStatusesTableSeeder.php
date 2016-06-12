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

class EmploymentStatusesTableSeeder extends Seeder
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
        DB::table('employment_statuses')->delete();

        DB::table('employment_statuses')->insert(
            [
                ['id' => 1, 'name' => 'Probationary', 'class' => 'label-danger'],
                ['id' => 2, 'name' => 'Regular', 'class' => 'label-success'],
                ['id' => 3, 'name' => 'Homebase', 'class' => 'label-warning'],
            ]
        );
    }
}

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

class TerminationReasonsTableSeeder extends Seeder
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
        DB::table('termination_reasons')->delete();

        DB::table('termination_reasons')->insert(
            [
                ['id' => 1, 'name' => 'Contract Not Renewed'],
                ['id' => 2, 'name' => 'Deceased'],
                ['id' => 3, 'name' => 'Dismissed'],
                ['id' => 4, 'name' => 'Laid-off'],
                ['id' => 5, 'name' => 'Other'],
                ['id' => 6, 'name' => 'Physically Disabled/Compensated'],
                ['id' => 7, 'name' => 'Resigned'],
                ['id' => 8, 'name' => 'Resigned - Company Requested'],
                ['id' => 9, 'name' => 'Resigned - Self Proposed'],
                ['id' => 10, 'name' => 'Retired'],
            ]
        );
    }
}

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

class RelationshipsTableSeeder extends Seeder
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
        DB::table('relationships')->delete();

        DB::table('relationships')->insert(
            [
                ['id' => 1, 'name' => 'Father'],
                ['id' => 2, 'name' => 'Mother'],
                ['id' => 3, 'name' => 'Brother'],
                ['id' => 4, 'name' => 'Sister'],
                ['id' => 5, 'name' => 'Spouse'],
                ['id' => 6, 'name' => 'Child'],
                ['id' => 7, 'name' => 'Grandfather'],
                ['id' => 8, 'name' => 'Grandmother'],
                ['id' => 9, 'name' => 'Other'],
            ]
        );
    }
}

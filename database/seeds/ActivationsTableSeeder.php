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

class ActivationsTableSeeder extends Seeder
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
        DB::table('activations')->delete();

        DB::table('activations')->insert(
            [
                [
                    'id'           => 1,
                    'user_id'      => 1,
                    'code'         => 'E33Q3NTPjnZgvgjLRmzcRzuAVcY17tTo',
                    'completed'    => 1,
                    'completed_at' => '2014-10-21 22:56:12',
                    'created_at'   => '2014-10-21 22:56:12',
                    'updated_at'   => '2014-11-04 15:10:19',
                ],
                [
                    'id'           => 2,
                    'user_id'      => 2,
                    'code'         => '1X0H0OMSrx8BlAtwjon27DnsuXThZtNG',
                    'completed'    => 1,
                    'completed_at' => '2014-10-21 22:56:12',
                    'created_at'   => '2014-10-21 22:56:12',
                    'updated_at'   => '2014-10-31 02:05:22',
                ],
                [
                    'id'           => 3,
                    'user_id'      => 3,
                    'code'         => '02JI63aRsK2wvLksFJUpMNyGbeInH7Pv',
                    'completed'    => 1,
                    'completed_at' => '2014-10-21 22:56:12',
                    'created_at'   => '2014-10-21 22:56:12',
                    'updated_at'   => '2014-10-31 02:05:22',
                ],
            ]
        );
    }
}

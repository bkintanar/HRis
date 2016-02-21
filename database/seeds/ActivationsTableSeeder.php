<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
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

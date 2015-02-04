<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TaxTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tax_computations')->truncate();

        DB::table('tax_computations')->insert(
            [
                [
                    'id' => 1,
                    'ME_S' =>  1,
                    'ME1_S1' => 1,
                    'ME2_S2' => 1,
                    'ME3_S3' => 1,
                    'ME4_S4' => 1,
                    'percentage_over' => 0,
                    'exemption' => 0,
                ],
                [
                    'id' => 2,
                    'ME_S' => 2083,
                    'ME1_S1' => 3125,
                    'ME2_S2' => 4167,
                    'ME3_S3' => 5208,
                    'ME4_S4' => 6250,
                    'percentage_over' => .05,
                    'exemption' => 0,
                ],
                [
                    'id' => 3,
                    'ME_S' => 2500,
                    'ME1_S1' => 3542,
                    'ME2_S2' => 4583,
                    'ME3_S3' => 5625,
                    'ME4_S4' => 6667,
                    'percentage_over' => .10,
                    'exemption' => 20.83,
                ],
                [
                    'id' => 4,
                    'ME_S' => 3333,
                    'ME1_S1' => 4375,
                    'ME2_S2' => 5417,
                    'ME3_S3' => 6458,
                    'ME4_S4' => 7500,
                    'percentage_over' => .15,
                    'exemption' => 104.17,
                ],
                [
                    'id' => 5,
                    'ME_S' => 5000,
                    'ME1_S1' => 6042,
                    'ME2_S2' => 7083,
                    'ME3_S3' => 8125,
                    'ME4_S4' => 9167,
                    'percentage_over' => .20,
                    'exemption' => 354.17,
                ],
                [
                    'id' => 6,
                    'ME_S' => 7917,
                    'ME1_S1' => 8958,
                    'ME2_S2' => 10000,
                    'ME3_S3' => 11042,
                    'ME4_S4' => 12083,
                    'percentage_over' => .25,
                    'exemption' => 937.50,
                ],
                [
                    'id' => 7,
                    'ME_S' => 12500,
                    'ME1_S1' => 13542,
                    'ME2_S2' => 14583,
                    'ME3_S3' => 15625,
                    'ME4_S4' => 16667,
                    'percentage_over' => .30,
                    'exemption' => 2083.33,
                ],
                [
                    'id' => 8,
                    'ME_S' => 22917,
                    'ME1_S1' => 23958,
                    'ME2_S2' => 25000,
                    'ME3_S3' => 26042,
                    'ME4_S4' => 27083,
                    'percentage_over' => .32,
                    'exemption' => 5208.33,
                ]
            ]
        );
    }

}

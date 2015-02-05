<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TerminationReasonsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
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

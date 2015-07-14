<?php

use Illuminate\Database\Seeder;

class JobHistoriesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_histories')->delete();

        DB::table('job_histories')->insert(
            [
                [
                    'id'                   => 1,
                    'employee_id'          => 1,
                    'job_title_id'         => 7,
                    'department_id'        => 3,
                    'employment_status_id' => 2,
                    'location_id'          => 1,
                    'effective_date'       => null,
                    'comments'             => null
                ],
                [
                    'id'                   => 2,
                    'employee_id'          => 2,
                    'job_title_id'         => 9,
                    'department_id'        => 3,
                    'employment_status_id' => 2,
                    'location_id'          => 1,
                    'effective_date'       => null,
                    'comments'             => null
                ],
            ]
        );
    }

}

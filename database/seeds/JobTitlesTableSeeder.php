<?php

use HRis\JobTitle;
use Illuminate\Database\Seeder;

class JobTitlesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_titles')->delete();

        DB::table('job_titles')->insert(
            [
                ['id' => 0, 'name' => '--- Select ---', 'description' => ''],
                ['id' => 1, 'name' => 'Operations Manager', 'description' => ''],
                ['id' => 2, 'name' => 'Project Manager', 'description' => ''],
                ['id' => 3, 'name' => 'HR Officer', 'description' => ''],
                ['id' => 4, 'name' => 'Admin Staff', 'description' => ''],
                ['id' => 5, 'name' => 'Team Leader', 'description' => ''],
                ['id' => 6, 'name' => 'Call Center Agent', 'description' => ''],
                ['id' => 7, 'name' => 'Sr Web Developer', 'description' => ''],
                ['id' => 8, 'name' => 'Jr Web Developer', 'description' => ''],
                ['id' => 9, 'name' => 'Sr Web Designer', 'description' => ''],
                ['id' => 10, 'name' => 'Jr Web Designer', 'description' => ''],
                ['id' => 11, 'name' => 'System Admin', 'description' => ''],
            ]
        );

        $job_title = JobTitle::whereName('--- Select ---')->first();
        $job_title->id = 0;
        $job_title->save();
    }

}

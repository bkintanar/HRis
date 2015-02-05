<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
    }

}

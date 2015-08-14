<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Seeder;

class JobTitlesTableSeeder extends Seeder
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
        DB::table('job_titles')->delete();

        DB::table('job_titles')->insert(
            [
                ['id' => 1, 'name' => 'Chief Executive Officer', 'description' => ''],
                ['id' => 2, 'name' => 'Chief Technology Officer', 'description' => ''],
                ['id' => 3, 'name' => 'General Manager', 'description' => ''],
                ['id' => 4, 'name' => 'HR/Admin Manager', 'description' => ''],
                ['id' => 5, 'name' => 'IT Manager', 'description' => ''],
                ['id' => 6, 'name' => 'Manager', 'description' => ''],
                ['id' => 7, 'name' => 'Production Manager', 'description' => ''],
                ['id' => 8, 'name' => 'Office Manager', 'description' => ''],
                ['id' => 9, 'name' => 'Senior Web Developer', 'description' => ''],
                ['id' => 10, 'name' => 'Senior Web Designer', 'description' => ''],
                ['id' => 11, 'name' => 'Senior Editor/Team Leader', 'description' => ''],
                ['id' => 12, 'name' => 'Senior Video Editor', 'description' => ''],
                ['id' => 13, 'name' => 'Web Developer', 'description' => ''],
                ['id' => 14, 'name' => 'Web Designer', 'description' => ''],
                ['id' => 15, 'name' => 'Video Editor', 'description' => ''],
                ['id' => 16, 'name' => 'Graphic Artist/Editor', 'description' => ''],
                ['id' => 17, 'name' => 'Motion Graphic Artist', 'description' => ''],
                ['id' => 18, 'name' => 'QA Specialist', 'description' => ''],
                ['id' => 19, 'name' => 'Staff', 'description' => ''],
                ['id' => 20, 'name' => 'Utility/Messenger', 'description' => ''],
                ['id' => 21, 'name' => 'Article Writer', 'description' => ''],
            ]
        );
    }
}

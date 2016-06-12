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
                ['id' => 3, 'name' => 'VP Engineering', 'description' => ''],
                ['id' => 4, 'name' => 'General Manager', 'description' => ''],
                ['id' => 5, 'name' => 'HR/Admin Manager', 'description' => ''],
                ['id' => 6, 'name' => 'IT Manager', 'description' => ''],
                ['id' => 7, 'name' => 'Manager', 'description' => ''],
                ['id' => 8, 'name' => 'Production Manager', 'description' => ''],
                ['id' => 9, 'name' => 'Office Manager', 'description' => ''],
                ['id' => 10, 'name' => 'Senior Web Developer', 'description' => ''],
                ['id' => 11, 'name' => 'Senior Web Designer', 'description' => ''],
                ['id' => 12, 'name' => 'Senior Editor/Team Leader', 'description' => ''],
                ['id' => 13, 'name' => 'Senior Video Editor', 'description' => ''],
                ['id' => 14, 'name' => 'Web Developer', 'description' => ''],
                ['id' => 15, 'name' => 'Web Designer', 'description' => ''],
                ['id' => 16, 'name' => 'Video Editor', 'description' => ''],
                ['id' => 17, 'name' => 'Graphic Artist/Editor', 'description' => ''],
                ['id' => 18, 'name' => 'Motion Graphic Artist', 'description' => ''],
                ['id' => 19, 'name' => 'QA Specialist', 'description' => ''],
                ['id' => 20, 'name' => 'Staff', 'description' => ''],
                ['id' => 21, 'name' => 'Utility/Messenger', 'description' => ''],
                ['id' => 22, 'name' => 'Article Writer', 'description' => ''],
            ]
        );
    }
}

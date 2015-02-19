<?php

use HRis\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->delete();

        DB::table('departments')->insert(
            [
                ['id' => 10, 'name' => '--- Select ---'],
                ['id' => 1, 'name' => 'Administration'],
                ['id' => 2, 'name' => 'Human Resource'],
                ['id' => 3, 'name' => 'Development'],
                ['id' => 4, 'name' => 'Call Center'],
                ['id' => 5, 'name' => 'Customer Service'],
            ]
        );

        $department = Department::whereName('--- Select ---')->first();
        $department->id = 0;
        $department->save();
    }

}

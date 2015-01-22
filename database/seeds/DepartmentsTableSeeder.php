<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
				['id' => 1, 'name' => 'Administration'],
				['id' => 2, 'name' => 'Human Resource'],
				['id' => 3, 'name' => 'Development'],
				['id' => 4, 'name' => 'Call Center'],
				['id' => 5, 'name' => 'Customer Service'],
            ]
        );
	}

}

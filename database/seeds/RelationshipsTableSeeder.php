<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RelationshipsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        DB::table('relationships')->delete();

        DB::table('relationships')->insert(
            [
				['id' => 1, 'name' => 'Father'],
				['id' => 2, 'name' => 'Mother'],
				['id' => 3, 'name' => 'Brother'],
				['id' => 4, 'name' => 'Sister'],
				['id' => 5, 'name' => 'Spouse'],
				['id' => 6, 'name' => 'Child'],
				['id' => 7, 'name' => 'Grandfather'],
				['id' => 8, 'name' => 'Grandmother'],
				['id' => 10, 'name' => 'Other'],
            ]
        );
	}

}

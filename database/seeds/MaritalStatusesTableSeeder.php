<?php

use Illuminate\Database\Seeder;

class MaritalStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('marital_statuses')->delete();

        DB::table('marital_statuses')->insert(
            [
                ['id' => 1, 'name' => 'Single'],
                ['id' => 2, 'name' => 'Married'],
                ['id' => 3, 'name' => 'Other'],
            ]
        );
    }
}

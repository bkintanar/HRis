<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WorkShiftsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_shifts')->truncate();

        DB::table('work_shifts')->insert(
            [
                ['id' => 1, 'name' => 'Morning Shift', 'from_time' => '07:00:00', 'to_time' => '16:00:00', 'duration' => 9],
                ['id' => 2, 'name' => 'Night Shift', 'from_time' => '23:00:00', 'to_time' => '08:00:00', 'duration' => 9],
                ['id' => 3, 'name' => 'Afternoon Shift', 'from_time' => '14:00:00', 'to_time' => '23:00:00', 'duration' => 9],

            ]
        );
    }
}
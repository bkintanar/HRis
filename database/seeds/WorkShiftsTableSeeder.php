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
                [
                    'id'        => 1,
                    'name'      => 'Admin',
                    'from_time' => '06:00:00',
                    'to_time'   => '17:00:00',
                    'duration'  => 9
                ],
                [
                    'id'        => 2,
                    'name'      => '08:00 am - 05:00',
                    'from_time' => '08:00:00',
                    'to_time'   => '17:00:00',
                    'duration'  => 9
                ],
                [
                    'id'        => 3,
                    'name'      => '02:00 pm - 11:00 pm',
                    'from_time' => '14:00:00',
                    'to_time'   => '23:00:00',
                    'duration'  => 9
                ],
                [
                    'id'        => 4,
                    'name'      => '08:00 pm - 05:00 am',
                    'from_time' => '20:00:00',
                    'to_time'   => '05:00:00',
                    'duration'  => 9
                ],
                [
                    'id'        => 5,
                    'name'      => '11:00 pm - 08:00 am',
                    'from_time' => '23:00:00',
                    'to_time'   => '08:00:00',
                    'duration'  => 9
                ],
                [
                    'id'        => 6,
                    'name'      => '05:00 pm - 02:00 am',
                    'from_time' => '17:00:00',
                    'to_time'   => '02:00:00',
                    'duration'  => 9
                ],
                [
                    'id'        => 7,
                    'name'      => '06:00 pm - 03:00 am',
                    'from_time' => '18:00:00',
                    'to_time'   => '03:00:00',
                    'duration'  => 9
                ],

            ]
        );
    }
}
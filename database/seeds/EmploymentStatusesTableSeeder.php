<?php

use HRis\EmploymentStatus;
use Illuminate\Database\Seeder;

class EmploymentStatusesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employment_statuses')->delete();

        DB::table('employment_statuses')->insert(
            [
                ['id' => 10, 'name' => '--- Select ---', 'class' => ''],
                ['id' => 1, 'name' => 'Probationary', 'class' => 'label-danger'],
                ['id' => 2, 'name' => 'Regular', 'class' => 'label-success'],
                ['id' => 3, 'name' => 'Homebase', 'class' => 'label-warning'],
            ]
        );

        $employment_status = EmploymentStatus::whereName('--- Select ---')->first();
        $employment_status->id = 0;
        $employment_status->save();
    }

}

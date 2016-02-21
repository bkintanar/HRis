<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Seeder;

class EmploymentStatusesTableSeeder extends Seeder
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
        DB::table('employment_statuses')->delete();

        DB::table('employment_statuses')->insert(
            [
                ['id' => 1, 'name' => 'Probationary', 'class' => 'label-danger'],
                ['id' => 2, 'name' => 'Regular', 'class' => 'label-success'],
                ['id' => 3, 'name' => 'Homebase', 'class' => 'label-warning'],
            ]
        );
    }
}

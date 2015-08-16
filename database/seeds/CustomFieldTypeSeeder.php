<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Seeder;

class CustomFieldTypeSeeder extends Seeder
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
        DB::table('custom_field_types')->delete();

        DB::table('custom_field_types')->insert(
            [
                ['name' => 'Text'],
                ['name' => 'Drop Down'],
                ['name' => 'Number'],
                ['name' => 'Email'],
                ['name' => 'Text Area'],
                ['name' => 'Date'],
                ['name' => 'Checkboxes'],
                ['name' => 'Radio Buttons'],
                ['name' => 'Attachments'],
                ['name' => 'Currency'],
                ['name' => 'Country'],
            ]
        );
    }
}

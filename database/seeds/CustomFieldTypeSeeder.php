<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
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
                ['name' => 'Text', 'has_options' => false],
                ['name' => 'Drop Down', 'has_options' => true],
                ['name' => 'Number', 'has_options' => false],
                ['name' => 'Email', 'has_options' => false],
                ['name' => 'Text Area', 'has_options' => false],
                ['name' => 'Date', 'has_options' => false],
                ['name' => 'Checkboxes', 'has_options' => true],
                ['name' => 'Radio Buttons', 'has_options' => true],
                ['name' => 'Attachments', 'has_options' => false],
                ['name' => 'Currency', 'has_options' => false],
                ['name' => 'Country', 'has_options' => false],
            ]
        );
    }
}

<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
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

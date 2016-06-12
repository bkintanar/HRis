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
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalaryComponentsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     *
     * @author Jim Callanta
     */
    public function down()
    {
        Schema::drop('salary_components');
    }

    /**
     * Run the migrations.
     *
     * @return void
     *
     * @author Jim Callanta
     */
    public function up()
    {
        Schema::create('salary_components', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('type');
            $table->integer('part_of_total_payable');
            $table->integer('cost_to_company');
        });
    }
}

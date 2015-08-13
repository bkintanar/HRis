<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalaryComponentsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
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

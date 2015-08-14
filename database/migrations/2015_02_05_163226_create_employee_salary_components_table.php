<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeeSalaryComponentsTable extends Migration
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
        Schema::drop('employee_salary_components');
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
        Schema::create('employee_salary_components', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_id');
            $table->integer('component_id');
            $table->decimal('value', 10, 2);
            $table->date('effective_date')->nullable();
        });
    }
}

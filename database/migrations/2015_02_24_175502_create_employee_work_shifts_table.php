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

class CreateEmployeeWorkShiftsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     * @author Bertrand Kintanar
     */
    public function down()
    {
        Schema::drop('employee_work_shifts');
    }

    /**
     * Run the migrations.
     *
     * @return void
     * @author Bertrand Kintanar
     */
    public function up()
    {
        Schema::create('employee_work_shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('work_shift_id');
            $table->date('effective_date')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('work_shift_id')->references('id')->on('work_shifts')->onDelete('cascade');
        });
    }
}

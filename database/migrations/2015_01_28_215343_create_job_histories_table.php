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

class CreateJobHistoriesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     *
     * @author Bertrand Kintanar
     */
    public function down()
    {
        Schema::drop('job_histories');
    }

    /**
     * Run the migrations.
     *
     * @return void
     *
     * @author Bertrand Kintanar
     */
    public function up()
    {
        Schema::create('job_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('job_title_id')->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('employment_status_id')->nullable();
            $table->unsignedInteger('work_shift_id')->nullable();
            $table->unsignedInteger('location_id')->nullable();
            $table->date('effective_date')->nullable();
            $table->text('comments')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('job_title_id')->references('id')->on('job_titles')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('employment_status_id')->references('id')->on('employment_statuses')->onDelete('cascade');
            $table->foreign('work_shift_id')->references('id')->on('work_shifts')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }
}

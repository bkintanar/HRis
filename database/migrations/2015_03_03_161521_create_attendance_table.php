<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendanceTable extends Migration
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
        Schema::drop('attendance');
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
        Schema::create('attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->date('work_date');
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->string('remarks')->nullable();
        });
    }
}

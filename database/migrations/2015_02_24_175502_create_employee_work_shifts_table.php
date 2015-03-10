<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeeWorkShiftsTable extends Migration {

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employee_work_shifts');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_work_shifts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('employee_id');
            $table->integer('work_shift_id');
            $table->date('effective_date')->nullable();
        });
    }

}

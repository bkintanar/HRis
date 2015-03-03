<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('attendance', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('employee_id');
            $table->date('work_date');
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->string('remarks')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('attendance');
	}

}

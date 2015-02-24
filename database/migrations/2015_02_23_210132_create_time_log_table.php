<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('time_log', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('face_id');
            $table->date('swipe_date');
            $table->time('swipe_time');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('time_log');
	}

}

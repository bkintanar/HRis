<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimeLogTable extends Migration {

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('time_log');
    }

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
            $table->datetime('swipe_datetime');
        });
    }

}

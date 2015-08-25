<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timelogs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type_id')->nullable();
            $table->unsignedInteger('holiday_id')->nullable();
            $table->unsignedInteger('employee_id')->nullable();
            $table->unsignedInteger('schedule_id')->nullable();
            $table->dateTime('in')->nullable();
            $table->dateTime('out')->nullable();
            $table->float('rendered_hours')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timelogs');
    }
}

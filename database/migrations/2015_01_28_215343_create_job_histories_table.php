<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobHistoriesTable extends Migration {

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_histories');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_histories', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('job_title_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('employment_status_id')->nullable();
            $table->integer('work_shift_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->date('effective_date')->nullable();
            $table->text('comments');
        });
    }
}

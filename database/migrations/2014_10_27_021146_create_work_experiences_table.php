<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkExperiencesTable extends Migration {

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('work_experiences');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_experiences', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('employee_id');
            $table->string('company');
            $table->string('job_title');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('comment');
        });
    }

}

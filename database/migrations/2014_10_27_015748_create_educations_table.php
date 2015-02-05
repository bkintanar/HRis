<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('education_level_id');
            $table->string('institute');
            $table->string('major_specialization');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('gpa_score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('educations');
    }

}

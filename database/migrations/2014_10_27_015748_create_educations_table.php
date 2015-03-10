<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEducationsTable extends Migration {

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('educations');
    }

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

}

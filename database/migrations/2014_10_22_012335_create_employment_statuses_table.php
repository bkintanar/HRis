<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmploymentStatusesTable extends Migration {

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employment_statuses');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_statuses', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('class');
        });
    }

}

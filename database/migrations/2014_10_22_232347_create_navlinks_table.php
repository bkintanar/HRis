<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNavlinksTable extends Migration {

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('navlinks');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navlinks', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('href');
            $table->string('icon');
            $table->integer('parent_id');
            $table->timestamps();
        });
    }

}

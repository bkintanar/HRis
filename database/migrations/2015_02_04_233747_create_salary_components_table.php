<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryComponentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('salary_components', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->integer('type');
            $table->integer('part_of_total_payable');
            $table->integer('cost_to_company');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('salary_components');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeSalaryComponentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_salary_components', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('employee_id');
            $table->integer('component_id');
            $table->decimal('value', 10, 2);
            $table->date('effective_date');
        });
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employee_salary_components');
    }

}

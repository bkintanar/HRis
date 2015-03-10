<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeeSalaryComponents extends Migration {

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employee_salary_components');
    }

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
            $table->date('effective_date')->nullable();
        });
    }

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('employees', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('employee_id');
            $table->integer('face_id')->nullable();
            $table->integer('user_id');
            $table->integer('job_title_id');
            $table->integer('department_id');
            $table->integer('employment_status_id');
            $table->integer('work_shift_id');
            $table->integer('marital_status_id');
            $table->integer('nationality_id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('suffix_name')->nullable();
            $table->string('avatar')->nullable();
            $table->char('gender', 1);
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->integer('address_city_id')->nullable();
            $table->integer('address_province_id')->nullable();
            $table->integer('address_country_id')->nullable();
            $table->string('address_postal_code')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('work_email')->nullable();
            $table->string('other_email')->nullable();
            $table->string('social_security')->nullable()->unique();
            $table->string('tax_identification')->nullable()->unique();
            $table->string('philhealth')->nullable()->unique();
            $table->string('hdmf_pagibig')->nullable()->unique();
            $table->string('mid_rtn')->nullable()->unique();
            $table->date('birth_date')->nullable();
            $table->string('remarks')->nullable();
            $table->date('hire_date')->nullable();
            $table->date('resign_date')->nullable();

            // We'll need to ensure that MySQL uses the InnoDB engine to
            // support the indexes, other engines aren't affected.
            $table->engine = 'InnoDB';
            $table->index('employee_id');
            $table->index('user_id');
            $table->index('job_title_id');
            $table->index('department_id');
            $table->index('employment_status_id');
            $table->index('marital_status_id');
            $table->index('work_shift_id');
            $table->index('nationality_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('employees');
	}

}

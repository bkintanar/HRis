<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDependentsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     *
     * @author Bertrand Kintanar
     */
    public function down()
    {
        Schema::drop('dependents');
    }

    /**
     * Run the migrations.
     *
     * @return void
     *
     * @author Bertrand Kintanar
     */
    public function up()
    {
        Schema::create('dependents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->unsignedInteger('relationship_id');
            $table->date('birth_date')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('relationship_id')->references('id')->on('relationships')->onDelete('cascade');
        });
    }
}

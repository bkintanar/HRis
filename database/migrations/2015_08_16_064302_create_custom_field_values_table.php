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

class CreateCustomFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     * @author Bertrand Kintanar
     */
    public function up()
    {
        Schema::create('custom_field_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('custom_field_id');
            $table->unsignedInteger('employee_id');
            $table->string('value')->nullable();

            $table->foreign('custom_field_id')->references('id')->on('custom_fields')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     *
     * @author Bertrand Kintanar
     */
    public function down()
    {
        Schema::drop('custom_field_values');
    }
}

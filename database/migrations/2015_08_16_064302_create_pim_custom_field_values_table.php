<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePimCustomFieldValuesTable extends Migration
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
        Schema::create('pim_custom_field_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pim_custom_field_id');
            $table->unsignedInteger('employee_id');
            $table->string('value');

            $table->foreign('pim_custom_field_id')->references('id')->on('pim_custom_fields')->onDelete('cascade');
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
        Schema::drop('pim_custom_field_values');
    }
}

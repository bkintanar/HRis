<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePimCustomFieldsTable extends Migration
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
        Schema::create('pim_custom_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pim_custom_field_section_id');
            $table->string('name');
            $table->unsignedInteger('pim_custom_field_type_id');
            $table->boolean('required');

            $table->foreign('pim_custom_field_section_id')->references('id')->on('pim_custom_field_sections')->onDelete('cascade');
            $table->foreign('pim_custom_field_type_id')->references('id')->on('pim_custom_field_types')->onDelete('cascade');
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
        Schema::drop('pim_custom_fields');
    }
}

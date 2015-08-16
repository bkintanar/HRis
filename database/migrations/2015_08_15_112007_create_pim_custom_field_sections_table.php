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

class CreatePimCustomFieldSectionsTable extends Migration
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
        Schema::create('pim_custom_field_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('screen_id');

            $table->foreign('screen_id')->references('id')->on('navlinks')->onDelete('cascade');

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
        Schema::drop('pim_custom_field_sections');
    }
}

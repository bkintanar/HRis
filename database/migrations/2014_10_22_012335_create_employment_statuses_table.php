<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmploymentStatusesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     * @author Bertrand Kintanar
     */
    public function down()
    {
        Schema::drop('employment_statuses');
    }

    /**
     * Run the migrations.
     *
     * @return void
     * @author Bertrand Kintanar
     */
    public function up()
    {
        Schema::create('employment_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('class');
        });
    }
}

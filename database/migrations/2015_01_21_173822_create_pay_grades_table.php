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

class CreatePayGradesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     * @author Bertrand Kintanar
     */
    public function down()
    {
        Schema::drop('pay_grades');
    }

    /**
     * Run the migrations.
     *
     * @return void
     * @author Bertrand Kintanar
     */
    public function up()
    {
        Schema::create('pay_grades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('min_salary');
            $table->integer('max_salary');
        });
    }
}

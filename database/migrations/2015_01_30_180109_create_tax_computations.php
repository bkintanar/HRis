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

class CreateTaxComputations extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     *
     * @author Jim Callanta
     */
    public function down()
    {
        Schema::drop('tax_computations');
    }

    /**
     * Run the migrations.
     *
     * @return void
     *
     * @author Jim Callanta
     */
    public function up()
    {
        Schema::create('tax_computations', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('ME_S', 10, 2);
            $table->decimal('ME1_S1', 10, 2);
            $table->decimal('ME2_S2', 10, 2);
            $table->decimal('ME3_S3', 10, 2);
            $table->decimal('ME4_S4', 10, 2);
            $table->decimal('percentage_over', 5, 2);
            $table->decimal('exemption', 10, 2);
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxComputations extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_computations', function (Blueprint $table)
        {
            $table->increments('id');
            $table->decimal('ME_S', 10, 2);
            $table->decimal('ME2_S2', 10, 2);
            $table->decimal('ME3_S3', 10, 2);
            $table->decimal('ME4_S4', 10, 2);
            $table->decimal('percentage_over', 5, 2);
            $table->decimal('exemption', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tax_computations');
    }

}

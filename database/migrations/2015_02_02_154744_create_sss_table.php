<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSssTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sss_contribution', function (Blueprint $table)
        {
            $table->increments('id');
            $table->decimal('range_compensation_from', 10, 2);
            $table->decimal('range_compensation_to', 10, 2);
            $table->decimal('monthly_salry_credit', 10, 2);
            $table->decimal('sss_er', 10, 2);
            $table->decimal('sss_ee', 10, 2);
            $table->decimal('sss_total', 10, 2);
            $table->decimal('ec_er', 10, 2);
            $table->decimal('total_contribution_er', 10, 2);
            $table->decimal('total_contribution_ee', 10, 2);
            $table->decimal('total_contribution_total', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sss_contribution');
    }

}

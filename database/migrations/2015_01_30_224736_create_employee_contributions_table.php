<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeeContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_contributions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_id');
            $table->decimal('SSS', 10, 2)->nullable();
            $table->decimal('PhilHealth', 10, 2)->nullable();
            $table->decimal('HDMF', 10, 2)->nullable();
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employee_contributions');
    }
}

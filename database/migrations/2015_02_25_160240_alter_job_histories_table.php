<?php

use Illuminate\Database\Migrations\Migration;

class AlterJobHistoriesTable extends Migration {

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'job_histories',
            function ($table)
            {
                $table->integer('work_shift_id');
            }
        );
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'job_histories',
            function ($table)
            {
                $table->dropColumn('work_shift_id');
            }
        );
    }

}

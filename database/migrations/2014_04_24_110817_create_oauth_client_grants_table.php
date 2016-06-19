<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This is the create oauth client grants table migration class.
 *
 * @author Luca Degasperi <packages@lucadegasperi.com>
 */
class CreateOauthClientGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_client_grants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 40);
            $table->string('grant_id', 40);
            $table->timestamps();

            $table->index('client_id');
            $table->index('grant_id');

            $table->foreign('client_id')
                  ->references('id')->on('oauth_clients')
                  ->onDelete('cascade')
                  ->onUpdate('no action');

            $table->foreign('grant_id')
                  ->references('id')->on('oauth_grants')
                  ->onDelete('cascade')
                  ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_client_grants', function (Blueprint $table) {
            $table->dropForeign('oauth_client_grants_client_id_foreign');
            $table->dropForeign('oauth_client_grants_grant_id_foreign');
        });
        Schema::drop('oauth_client_grants');
    }
}

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
 * This is the create oauth sessions table migration class.
 *
 * @author Luca Degasperi <packages@lucadegasperi.com>
 */
class CreateOauthSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 40);
            $table->enum('owner_type', ['client', 'user'])->default('user');
            $table->string('owner_id');
            $table->string('client_redirect_uri')->nullable();
            $table->timestamps();

            $table->index(['client_id', 'owner_type', 'owner_id']);

            $table->foreign('client_id')
                ->references('id')->on('oauth_clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_sessions', function (Blueprint $table) {
            $table->dropForeign('oauth_sessions_client_id_foreign');
        });
        Schema::drop('oauth_sessions');
    }
}

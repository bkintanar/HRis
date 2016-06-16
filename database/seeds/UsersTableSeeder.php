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

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Irradiate\Eloquent\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function run()
    {
        DB::table('users')->delete();

        foreach ($this->users() as $user) {
            User::create($user);
        }
    }

    /**
     * Users data.
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function users()
    {
        return [
            [
                'email'        => 'bertrand.kintanar@gmail.com',
                'password'     => Hash::make('retardko'),
                'last_login'   => Carbon::now(),
            ],
            [
                'email'        => 'gabstafari@gmail.com',
                'password'     => Hash::make('retardko'),
                'last_login'   => Carbon::now(),
            ],
            [
                'email'        => 'harlequin.doyon@gmail.com',
                'password'     => Hash::make('retardko'),
                'last_login'   => Carbon::now(),
            ],
        ];
    }
}

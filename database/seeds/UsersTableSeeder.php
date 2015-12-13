<?php

use Carbon\Carbon;
use HRis\Api\Eloquent\User;
use Illuminate\Database\Seeder;

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

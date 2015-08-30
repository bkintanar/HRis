<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Seeder;
use HRis\Eloquent\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @author Bertrand Kintanar
     */
    public function run()
    {
        DB::table('users')->delete();

        foreach ($this->users() as $user) {
            User::create($user);
        }
    }

    /**
     * Users data
     * @return array
     * @author Harlequin Doyon
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
                'email'        => 'gabriel@gmail.com',
                'password'     => Hash::make('retardko'),
                'last_login'   => Carbon::now(),
            ],
            [
                'email'        => 'harlequin.doyon@gmail.com',
                'password'     => Hash::make('123456'),
                'last_login'   => Carbon::now(),
            ],
        ];
    }
}

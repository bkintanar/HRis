<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert(
            [
                [
                    'id'           => 1,
                    'email'        => 'bertrand.kintanar@gmail.com',
                    'password'     => Hash::make('retardko'),
                    'last_login'   => '2014-11-04 15:10:19',
                    'created_at'   => '2014-10-21 22:56:12',
                    'updated_at'   => '2014-11-04 15:10:19'
                ],
                [
                    'id'           => 2,
                    'email'        => 'gabriel@gmail.com',
                    'password'     => Hash::make('retardko'),
                    'last_login'   => '2014-10-31 02:05:22',
                    'created_at'   => '2014-10-21 22:56:12',
                    'updated_at'   => '2014-10-31 02:05:22'
                ],
            ]
        );
    }
}

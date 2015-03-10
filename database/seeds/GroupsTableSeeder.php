<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: This should be seeding the groups table not the users table
        DB::table('users')->delete();

        DB::table('users')->insert(
            [
                [
                    'id'           => 1,
                    'email'        => 'bertrand@verticalops.com',
                    'password'     => Hash::make('retardko'),
                    'activated'    => 1,
                    'last_login'   => '2014-11-04 15:10:19',
                    'persist_code' => '$2y$10$Yi1M5EnDS7m4qTISNdtlTecU.uzaQxTrwV0V.TNAjNCFhOmLureJe',
                    'created_at'   => '2014-10-21 22:56:12',
                    'updated_at'   => '2014-11-04 15:10:19'
                ],
                [
                    'id'           => 2,
                    'email'        => 'gabriel@verticalops.com',
                    'password'     => Hash::make('retardko'),
                    'activated'    => 1,
                    'last_login'   => '2014-10-31 02:05:22',
                    'persist_code' => '$2y$10$86DzwaIpkTvaMC5aWSVS8eZiTkv0XqRB6LAOZNm9NY9MSZLbaky7i',
                    'created_at'   => '2014-10-21 22:56:12',
                    'updated_at'   => '2014-10-31 02:05:22'
                ],
            ]
        );
    }

}

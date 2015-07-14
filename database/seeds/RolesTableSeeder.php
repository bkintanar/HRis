<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: This should be seeding the groups table not the users table
        DB::table('roles')->delete();

        DB::table('roles')->insert(
            [
                [
                    'id'          => 1,
                    'slug'        => 'root',
                    'name'        => 'Root',
                    'permissions' => '{"superuser":"1"}',
                    'created_at'  => '2014-10-21 22:56:12',
                    'updated_at'  => '2014-11-04 15:10:19'
                ],
                [
                    'id'          => 2,
                    'slug'        => "administrator",
                    'name'        => "Administrator",
                    'permissions' => '{"superuser":"1"}',
                    'created_at'  => '2014-10-21 22:56:12',
                    'updated_at'  => '2014-10-31 02:05:22'
                ],
                [
                    'id'          => 3,
                    'slug'        => "ess",
                    'name'        => "Employee Self-service",
                    'permissions' => '',
                    'created_at'  => '2014-10-21 22:56:12',
                    'updated_at'  => '2014-10-31 02:05:22'
                ],
            ]
        );
    }

}

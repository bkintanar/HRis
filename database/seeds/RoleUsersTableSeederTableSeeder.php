<?php

use Illuminate\Database\Seeder;

class RoleUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_users')->delete();

        DB::table('role_users')->insert(
            [
                ['user_id' => 1, 'role_id' => 1],
                ['user_id' => 2, 'role_id' => 2],
            ]
        );
    }
}

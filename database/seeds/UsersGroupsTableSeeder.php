<?php

use Illuminate\Database\Seeder;

class UsersGroupsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_groups')->delete();

        DB::table('users_groups')->insert(
            [
                ['user_id' => 1, 'group_id' => 1],
                ['user_id' => 2, 'group_id' => 2],
            ]
        );
    }

}

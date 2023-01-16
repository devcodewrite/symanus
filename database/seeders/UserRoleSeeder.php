<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //added default role
        DB::table('user_roles')->insert([
            'title' => 'Administrator',
            'permission_id' => 2,
        ]);
    }
}

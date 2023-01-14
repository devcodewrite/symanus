<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => 'Super',
            'surname' => 'Administrator',
            'username' => 'admin',
            'sex' => 'male',
            'email' => 'admin@allghanaschools.com',
            'password' => Hash::make('pass'),
            'user_role_id' => 1,
            'email_verified_at' => date('Y-m-d H:i:s', )
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // add default super admin user
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@allghanaschools.com',
            'password' => Hash::make('pass'),
        ]);
    }
}

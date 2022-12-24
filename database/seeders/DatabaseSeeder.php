<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;

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
        $this->call([
            UserRoleSeeder::class,
            UserSeeder::class,
        ]);
       
    }
}

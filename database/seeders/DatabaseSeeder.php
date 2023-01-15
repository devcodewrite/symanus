<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Student;
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
            ModuleSeeder::class,
            SettingSeeder::class,
            PermissionSeeder::class,
            UserRoleSeeder::class,
            UserSeeder::class,
            AddRanApiTokenSeeder::class,
        ]);
       
    }
}

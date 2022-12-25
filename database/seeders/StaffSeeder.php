<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('staff')->insert([
            ['firstname' => 'Eric','surname' => 'Mensah', 'staffid' => rand(22120000,22129999), 'title'=>'Mr.', 'sex' => 'male'],
            ['firstname' => 'Isaac', 'surname' => 'Mensah', 'staffid' => rand(22120000,22129999), 'title'=>'Mr.', 'sex' => 'male']
        ]);
    }
}

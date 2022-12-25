<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('students')->insert([
            ['firstname' => 'Fred','surname' => 'Mensah', 'studentid' => rand(22120000,22129999),'sex' => 'male', 'class_id' => 1],
            ['firstname' => 'Pual', 'surname' => 'Mensah', 'studentid' => rand(22120000,22129999), 'sex' => 'male', 'class_id' => 2]
        ]);
    }
}

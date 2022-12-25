<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('classes')->insert([
            ['name' => 'CLASS ONE','level' => 0, 'staff_id' => 1],
            ['name' => 'CLASS TWO', 'level' => 1, 'staff_id' => 2]
        ]);
    }
}

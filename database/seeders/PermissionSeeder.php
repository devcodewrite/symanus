<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // admin permisson
        DB::table('permissions')->insert([[
            'id' => 1,
           'settings' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'permissions' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'modules' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'user_roles' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'users' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'students' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'guardians' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'classes' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'attendances' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'fee_types' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'fees' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'expense_types' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'expenses' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'bills' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'semesters' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'staffs' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'sms' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'locked' => 1,
           'is_admin' => 1,
        ],[
            'id' => 2,
           'settings' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'permissions' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'modules' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'user_roles' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'users' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'students' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'guardians' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'classes' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'attendances' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'fee_types' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'fees' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'expense_types' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'expenses' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'bills' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'semesters' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'staffs' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'sms' =>implode(",",['view','create','update', 'delete', 'force-delete','report']),
           'locked' => 1,
           'is_admin' => 1,
        ]]);
    }
}

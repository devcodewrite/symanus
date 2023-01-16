<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('modules')->insert([
            [
                'group_label' => 'Human Resource Management (HR)', 
                'name' => 'Users & Roles Management', 
                'description' => "Users / Employees and Roles management.",
                'status' => 'enabled',
                'default_status' => 'enabled',
                'locked' => 1
            ],
            [
                'group_label' => 'Human Resource Management (HR)', 
                'name' => 'Leave Request Management', 
                'description' => "Define and track employee leave requests.",
                'status' => 'disabled',
                'default_status' => 'disabled',
                'locked' => 0
            ],
            [
                'group_label' => 'Human Resource Management (HR)', 
                'name' => "Staff/Teachers Management", 
                'description' => "Manage both Teaching and Non-Teaching Staffs.",
                'status' => 'disabled',
                'default_status' => 'disabled',
                'locked' => 0
            ],
            [
                'group_label' => 'Students & Guardians Managment', 
                'name' => "Students Management", 
                'description' => "Students Management.",
                'status' => 'enabled',
                'default_status' => 'enabled',
                'locked' => 1
            ],
            [
                'group_label' => 'Students & Guardians Managment', 
                'name' => "Guardians Management", 
                'description' => "Allows you to manage Guardians' User Accounts.",
                'status' => 'enabled',
                'default_status' => 'enabled',
                'locked' => 0
            ],
            [
                'group_label' => 'Education Managment', 
                'name' => "Classes Management", 
                'description' => "Manage classes and assign Teachers to Classes.",
                'status' => 'enabled',
                'default_status' => 'enabled',
                'locked' => 1
            ],
            [
                'group_label' => 'Education Managment', 
                'name' => "Courses Management", 
                'description' => "Manage courses, assign Teachers to courses and make assessements.",
                'status' => 'disabled',
                'default_status' => 'disabled',
                'locked' => 1
            ],
            [
                'group_label' => 'Education Managment', 
                'name' => "Report Card Management", 
                'description' => "Generate report cards and promote students by assessments. This requires Courses Management Module.",
                'status' => 'disabled',
                'default_status' => 'disabled',
                'locked' => 1
            ],
            [
                'group_label' => 'Education Managment', 
                'name' => "Attendance Management", 
                'description' => "Manage student attendance.",
                'status' => 'enabled',
                'default_status' => 'enabled',
                'locked' => 0
            ],
            [
                'group_label' => 'Finance & Accounting Management', 
                'name' => "Fees Collection Management", 
                'description' => "Manage fee collection for canteen, transport or bus fees, school fees etc. Canteen fees and transport or bus fees requires Attendance Management Module.",
                'status' => 'enabled',
                'default_status' => 'enabled',
                'locked' => 0
            ],
            [
                'group_label' => 'Finance & Accounting Management', 
                'name' => "Expense Management", 
                'description' => "Manage user/employees expenses.",
                'status' => 'disabled',
                'default_status' => 'enabled',
                'locked' => 0
            ],

            [
                'group_label' => 'Reporting and Export Management', 
                'name' => "Reporting Management", 
                'description' => "Manage all forms of reportings.",
                'status' => 'enabled',
                'default_status' => 'enabled',
                'locked' => 0
            ],
            [
                'group_label' => 'Reporting and Export Management', 
                'name' => "Export Management", 
                'description' => "Allow export of data tables and records.",
                'status' => 'disabled',
                'default_status' => 'enabled',
                'locked' => 0
            ],
            [
                'group_label' => 'Notification Management', 
                'name' => "SMS Management", 
                'description' => "Enable SMS notifications.",
                'status' => 'enabled',
                'default_status' => 'enabled',
                'locked' => 0
            ],
        ]);
    }
}

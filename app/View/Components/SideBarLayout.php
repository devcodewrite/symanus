<?php

namespace App\View\Components;

use Illuminate\View\Component;

use App\Models\Attendance;
use App\Models\AttendanceStudent;
use App\Models\Bill;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Expense;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Guardian;
use App\Models\Module;
use App\Models\Payment;
use App\Models\Permission;
use App\Models\Semester;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use App\Models\UserRole;

class SideBarLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data = [
            'setting' => new Setting(),
            'module' => new Module(),
            'student' => new Student(),
            'attendance' => new Attendance(),
            'course' => new Course(),
            'fee' => new Fee(),
            'guardian' => new Guardian(),
            'permission' => new Permission(),
            'staff' => new Staff(),
            'class' => new Classes(),
            'payment' => new Payment(),
            'bill' => new Bill(), 
            'feeType' => new FeeType(),
            'userRole' => new UserRole(),
            'semester' => new Semester(),
            'expense' => new Expense(),
            'staff' => new Staff(),
        ];
        return view('layouts.sidebar', $data);
    }
}

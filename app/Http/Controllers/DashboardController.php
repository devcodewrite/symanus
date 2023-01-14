<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Fee;
use App\Models\Guardian;
use App\Models\Module;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard request view.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        
        $data = [
            'setting' => new Setting(),
            'user' => new User(),
            'student' => new Student(),
            'attendance' => new Attendance(),
            'course' => new Course(),
            'fee' => new Fee(),
            'guardian' => new Guardian(),
            'staff' => new Staff(),
            'class' => new Classes(),
            'payment' => new Payment(),
            'module' => new Module(),
        ];

        return view('dashboard', $data);
    }
}

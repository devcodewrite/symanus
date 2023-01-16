<?php

namespace App\View\Components;

use App\Models\Module;
use App\Models\Setting;
use Illuminate\View\Component;
use App\Models\Attendance;
use App\Models\AttendanceStudent;
use App\Models\Bill;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Guardian;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $data = [
            'setting' => new Setting(),
            'module' => new Module(),
        ];
        return view('layouts.app', $data);
    }
}

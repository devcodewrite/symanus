<?php

namespace App\Http\Controllers;

use App\Models\AdvanceFeePayment;
use App\Models\Attendance;
use App\Models\AttendanceStudent;
use App\Models\Bill;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Guardian;
use App\Models\Module;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\SMS;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use App\Notifications\StudentAbsent;
use DB;
use Illuminate\Http\Request;
use Notification;

class DashboardController extends Controller
{
    /**
     * Display the dashboard request view.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
      
        $bill = Bill::find(1);
        if ($bill->attendance_id) {
            $advances = AdvanceFeePayment::where('attendance_id', $bill->attendance_id)->get();

            $payments = [];
           //dd($bill);
            foreach ($advances as $advance) {
                $fee = $bill->fees()->where('fee_type_id', $advance->fee_type_id)->first();
                if(!$fee) continue;
                $billAmount = $fee->findBillFee($bill->id)->amount;
                if($advance->amount - $billAmount >= 0){
                    $advance->amount = $advance->amount - $billAmount;
                    array_push($payments,[
                        'bill_id' => $bill->id,
                        'amount' => $billAmount,
                        'fee_type_id' => $advance->fee_type_id,
                        'student_id' => $bill->student_id,
                        'paid_by' => $advance->paid_by,
                        'user_id' => auth()->user()->id,
                        'paid_at' => $advance->paid_at,
                    ]);
                    $advance->save();
                }
            }
            //dd($payments);
           if(sizeof($payments) > 0){
            if(DB::table('payments')->upsert($payments, ['student_id', 'fee_type_id'], ['bill_id'])){
                AdvanceFeePayment::where('amount','<=', 0)->delete();
            }
        }
        }

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
            'bill' => new Bill(),
            'module' => new Module(),
            'sms' => new SMS(),
        ];

        return view('dashboard', $data);
    }
}

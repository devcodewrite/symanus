<?php

namespace App\Observers;

use App\Models\Attendance;
use App\Models\Bill;
use App\Models\BillFee;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Guardian;
use App\Notifications\StudentAbsent;
use Illuminate\Http\Request;
use Notification;

class AttendanceObserver
{
    /**
     * Handle the Attendance "created" event.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return void
     */
    public function created(Attendance $attendance)
    {
        // if auto generate bill is check for attendance
        if($attendance){
            dd($attendance);
            $billFees = [];
            foreach($attendance->students as $student){
                    $bill =  Bill::updateOrCreate(['user_id' => auth()->user()->id],['student_id' => $student->id,'bdate' => $attendance->adate]);
                    foreach($student->fees as $fee)
                    //    if($fee->feeType->bill_ex_st_affiliation !== $student->affiliation
                      //  || $fee->feeType->bill_ex_st_transit !== $student->transit)
                            array_push($billFees,['bill_id'=>$bill->id, 'fee_id' => $fee->id]);  
            }
            if(sizeof($billFees) > 0)
                BillFee::updateOrCreate($billFees);
        }
    }

    /**
     * Handle the Attendance "updated" event.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return void
     */
    public function updated(Attendance $attendance)
    {
        if($attendance->status === 'approved'){
            Notification::send($attendance->absentStudents, new StudentAbsent($attendance));
        }
    }

    /**
     * Handle the Attendance "deleted" event.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return void
     */
    public function deleted(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the Attendance "restored" event.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return void
     */
    public function restored(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the Attendance "force deleted" event.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return void
     */
    public function forceDeleted(Attendance $attendance)
    {
        //
    }
}

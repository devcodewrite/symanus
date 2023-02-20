<?php

namespace App\Observers;

use App\Models\Attendance;
use App\Models\Bill;
use App\Models\BillFee;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Guardian;
use App\Notifications\AttendanceApproved;
use App\Notifications\AttendanceRejected;
use App\Notifications\AttendanceSubmitted;
use App\Notifications\StudentAbsent;
use DB;
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
            $attendance->settleBills();
            Notification::send($attendance->absentStudents, new StudentAbsent($attendance));
            $attendance->user->notify(new AttendanceApproved($attendance));
        }
        else if($attendance->status === 'rejected'){
            $attendance->user->notify(new AttendanceRejected($attendance));
        }
        else if($attendance->status === 'submitted'){
            //dd($attendance->approvalUser);
            $attendance->approvalUser->notify(new AttendanceSubmitted($attendance));
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
        foreach($attendance->bills as $bill){
            if(DB::table('bill_fees')->where('bill_id', $bill->id)->delete()){
                $bill->delete();
            }
        }

        foreach($attendance->advancePaments as $payment){
            $payment->delete();
        }
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

<?php

namespace App\Observers;

use App\Models\AttendanceStudent;
use App\Models\FeeType;
use App\Models\Student;
use App\Notifications\StudentAbsent;

class AttendanceStudentObserver
{
    /**
     * Handle the AttendanceStudent "created" event.
     *
     * @param  \App\Models\AttendanceStudent  $attendanceStudent
     * @return void
     */
    public function created(AttendanceStudent $attendanceStudent)
    {
        //
    }

    /**
     * Handle the AttendanceStudent "updated" event.
     *
     * @param  \App\Models\AttendanceStudent  $attendanceStudent
     * @return void
     */
    public function updated(AttendanceStudent $attendanceStudent)
    {
        // this is to exclude bills
       if($attendanceStudent->status === 'absent'){
            $feeTypes = FeeType::where('bill_ex_st_attendance', 'absent')->get();
            $types = [];
            foreach($feeTypes as $type) array_push($types, $type->id);
            //deleting any payment made for bill
            $attendanceStudent->student
                    ->bills()
                    ->whereIn('fee_type_id', $types)
                    ->delete();
       }else {
        $feeTypes = FeeType::where('bill_ex_st_attendance', 'present')->get();
        $types = [];
        foreach($feeTypes as $type) array_push($types, $type->id);
        //deleting any payment made for bill
        $attendanceStudent->student
                ->bills()
                ->whereIn('fee_type_id', $types)
                ->get();
       }
    }

    /**
     * Handle the AttendanceStudent "deleted" event.
     *
     * @param  \App\Models\AttendanceStudent  $attendanceStudent
     * @return void
     */
    public function deleted(AttendanceStudent $attendanceStudent)
    {
        //
    }

    /**
     * Handle the AttendanceStudent "restored" event.
     *
     * @param  \App\Models\AttendanceStudent  $attendanceStudent
     * @return void
     */
    public function restored(AttendanceStudent $attendanceStudent)
    {
        //
    }

    /**
     * Handle the AttendanceStudent "force deleted" event.
     *
     * @param  \App\Models\AttendanceStudent  $attendanceStudent
     * @return void
     */
    public function forceDeleted(AttendanceStudent $attendanceStudent)
    {
        //
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes are mass assignable
     * @var array
     */
    protected $fillable = [
        'adate', 'class_id', 'user_id','approval_user_id', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d/m/y h:i a',
        'updated_at' => 'datetime:d/m/y h:i a'
    ];

    /**
     * Get the class that owns the attendance.
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get the user that owns the attendance.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the approval user that owns the attendance.
     */
    public function approvalUser()
    {
        return $this->belongsTo(User::class, 'approval_user_id');
    }

    /**
     * The students that belong to the attendance.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'attendance_students');
    }

    /**
     * The students that belong to the attendance.
     */
    public function checklist()
    {
        return $this->hasMany(AttendanceStudent::class, 'attendance_id');
    }

    /**
     * The students that belong to the attendance absent
     */
    public function absentStudents()
    {
        return
            $this->belongsToMany(Student::class, 'attendance_students')
            ->where('attendance_students.status', 'absent');
    }

    /**
     * The students that belong to the attendance present
     */
    public function presentStudents()
    {
        return
            $this->belongsToMany(Student::class, 'attendance_students')
            ->where('attendance_students.status', 'present')
            ->get();
    }

    /**
     * The guardians that belong to the attendance.
     */
    public function studentGuardians()
    {
        return $this->hasMany(Guardian::class, 'attendance_students');
    }

    /**
     * The bills that belong to the attendance.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class, 'attendance_id');
    }

    /**
     * The bills that belong to the attendance.
     */
    public function advancePaments()
    {
        return $this->hasMany(AdvanceFeePayment::class, 'attendance_id');
    }
    public function totalAdvance()
    {
        return $this->advancePaments()->sum('amount');
    }

    public function expectedPayments()
    {
        return BillFee::join('bills', 'bills.id', '=', 'bill_fees.bill_id')
            ->join('attendance_students', 'attendance_students.student_id', 'bills.student_id')
            ->where('bills.attendance_id', $this->id)
            ->where('attendance_students.attendance_id', $this->id)
            ->where('attendance_students.status', 'present')
            ->leftJoin('payments', 'payments.bill_id', 'bills.id')
            ->sum(DB::raw('bill_fees.amount - ifnull(payments.amount,0)'));
    }
    public function totalBill()
    {
        return $this->bills()
            ->join('bill_fees', 'bill_fees.bill_id', '=', 'bills.id')
            ->where('bills.attendance_id', $this->id)
            ->sum('bill_fees.amount');
    }

    public function totalStudent()
    {
        return $this->students->count();
    }

    public function studentPresent()
    {
        return $this->students->count() - $this->absentStudents()->count();
    }

    public function studentAbsent()
    {
        return $this->absentStudents()->count();
    }

    public function settleBills()
    {
        $payments = [];
        foreach ($this->presentStudents() as $student) {
            $bfs = Bill::where([
                'student_id' => $student->id,
                'attendance_id'  => $this->id,
            ])->first()->billFees;
            foreach($bfs as $bf)
                array_push($payments, 
                [
                    'student_id' => $student->id,
                    'amount' => $bf->amount,
                    'paid_at' => Carbon::now('Africa/Accra')->format('Y-m-d'),
                    'paid_by' => $student->firstname . ' ' . $student->surname,
                    'bill_id' => $bf->bill_id,
                    'fee_type_id' => $bf->fee->fee_type_id,
                    'user_id' => auth()->user()->id,
                    'created_at' => Carbon::now('Africa/Accra'),
                    'updated_at' => Carbon::now('Africa/Accra'),
                ]);
        }

     return DB::table('payments')->insert($payments);
    }

    public function removeBills()
    {
        foreach ($this->presentStudents() as $student) {
            $b = Bill::where([
                'student_id' => $student->id,
                'attendance_id'  => $this->id,
            ])->first();
            Payment::where(['bill_id'=> $b->id])->delete();
        }
        
    }
}

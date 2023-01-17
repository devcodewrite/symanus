<?php

namespace App\Models;

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
        'adate', 'class_id', 'user_id', 'status'
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

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
            ->where('attendance_students.status', 'absent')
            ->get();
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
        return $this->belongsToMany(Student::class, 'attendance_students')
                ->join('bills', 'bills.student_id','=', 'attendance_students.student_id')
                ->join('bill_fees', 'bill_fees.bill_id', '=', 'bills.id')
                ->where('attendance_students.status', 'present')
                ->sum('bill_fees.amount');
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
}

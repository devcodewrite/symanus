<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceStudent extends Model
{
    use HasFactory;

    /**
     * The attributes are mass assignable
     * @var array
     */
    protected $fillable = [
        'attendance_id', 'student_id', 'status'
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
    ];

     /**
     * Get the user that owns the attendance-student.
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

     /**
     * Get the student that owns the attendance-student.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

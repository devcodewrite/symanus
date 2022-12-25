<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

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
    public function attendances()
    {
        return $this->belongsToMany(Student::class, 'attendance_students');
    }
}

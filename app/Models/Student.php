<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'studentid', 'firstname', 'surname', 'sex', 'address', 'dateofbirth', 'avatar',
        'rstatus', 'admitted_at', 'transit', 'affiliation', 'linked_files'
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
    * Get the guardian that owns the student.
    */
    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    /**
    * Get the class that owns the student.
    */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get the payments for the student.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
    * The attendances that belong to the student.
    */
    public function attendances()
    {
        return $this->belongsToMany(Attendance::class, 'attendance_students');
    }
}

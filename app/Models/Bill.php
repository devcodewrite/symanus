<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    /**
     * The attributes are mass assignable
     * @var array
     */
    protected $fillable = [
        'student_id', 'bdate', 'user_id'
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d/m/y h:i A',
        'updated_at' => 'datetime:d/m/y h:i A'
    ];

    /**
     * Get the user that owns the fee.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get the student that owns the fee.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
    * The fees that belong to the bill.
    */
    public function fees()
    {
        return $this->belongsToMany(Fee::class, 'bill_fees');
    }

    /**
     * Get the payments for the bill.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
}

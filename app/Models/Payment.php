<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes are mass assignable
     * @var array
     */
    protected $fillable = [
        'paid_at', 'student_id', 'fee_type_id', 'amount', 'paid_by', 'user_id', 'bill_id',
        'create_at','updated_at'
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
    * Get the student that owns the payment.
    */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
    * Get the user that owns the payment.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
    * Get the fee type that owns the payment.
    */
    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}

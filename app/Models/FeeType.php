<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeType extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'status',
        'bill_ex_st_affiliation',
        'bill_ex_st_transit',
        'bill_ex_st_attendance',
        'for_attendance_bills'
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
        'updated_at' => 'datetime:d/m/y h:i a',
        'for_attendance_bills' => 'boolean',
    ];

    /**
     * Get the fees for the feeType.
     */
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    /**
     * Get the payments for the feeType.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

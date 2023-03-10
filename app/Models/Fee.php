<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Builder\Class_;

class Fee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes are mass assignable
     * @var array
     */
    protected $fillable = [
        'description', 'class_id', 'rstatus', 'fee_type_id','amount',
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
     * Get the class that owns the fee.
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
    
     /**
     * Get the fee type that owns the fee.
     */
    public function feeType()
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id');
    }
    public function findBillFee($bill)
    {
        return $this->hasMany(BillFee::class)->where('bill_fees.bill_id', $bill)->first();
    }
    /*
    * Get the students for the fee.
    */
   public function students()
   {
       return $this->hasManyThrough(Student::class, Classes::class);
   }
    
}

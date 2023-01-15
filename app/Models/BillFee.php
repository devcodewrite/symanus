<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillFee extends Model
{
    use HasFactory;

    /**
     * The attributes are mass assignable
     * @var array
     */
    protected $fillable = [
        'bill_id', 'fee_id',
    ];

     /**
    * Get the fee that owns the billfee.
    */
    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    /**
    * Get the bill that owns the billfee.
    */
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }


}
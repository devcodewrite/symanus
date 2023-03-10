<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes are mass assignable
     * @var array
     */
    protected $fillable = [
        'name', 'level', 'user_id'
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
        'created_at' => 'datetime:d/m/y h:i A',
        'updated_at' => 'datetime:d/m/y h:i A',
        'level' => 'integer'
    ];

    /**
     * Get the user that owns the class.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the courses for the class.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the students for the class.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    /**
     * Get the payments for the class.
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Student::class, 'class_id');
    }

    /**
     * Get the advance payments for the class.
     */
    public function advancePayments()
    {
        return $this->hasManyThrough(AdvanceFeePayment::class, Student::class, 'class_id');
    }

     /**
     * Get the fees for the class.
     */
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    /**
     * Get the bills for the class.
     */
    public function bills()
    {
        return $this->hasManyThrough(Bill::class, Student::class, 'class_id');
    }

    public function billReport(FeeType $feeType = null, $from = null, $to = null)
    {
        $from = $from ? $from : Bill::orderBy('bdate', 'desc')->first()->bdate;
        $to = $to ? $to : Bill::orderBy('bdate', 'asc')->first()->bdate;
      //  $to = Carbon::createFromFormat('Y-m-d', $to)->addDay();

        if ($feeType) {
            $bills = $this->bills()->whereBetween('bdate', [$from, $to])->get();
            $totalBills = 0;
            foreach ($bills as $bill) {
                $totalBills += $bill->billFees()->join('fees', 'fees.id', '=', 'bill_fees.fee_id')
                    ->where('fee_type_id', $feeType->id)
                    ->sum('bill_fees.amount');
            }
            return $totalBills;
        }

        $bills = $this->bills()
            ->whereBetween('bdate', [$from, $to])
            ->get();

        $totalBills = 0;
        foreach ($bills as $bill) {
            $totalBills += $bill->totalBill();
        }
        return $totalBills;
    }

    public function incomeReport(FeeType $feeType = null, $from = null, $to = null)
    {
        $from = $from?$from:Payment::orderBy('paid_at', 'desc')->first()->created_at;
        $to = $to?$to:Payment::orderBy('paid_at', 'asc')->first()->created_at;
       // $to = Carbon::createFromFormat('Y-m-d', $to)->addDay();

       if($feeType){
        $totalPayment = $this->payments()
                ->where('fee_type_id', $feeType->id)
                ->whereBetween('paid_at', [$from, $to])
                ->sum('amount');
        return $totalPayment;
       }
       $totalPayment = $this->payments()
                ->whereBetween('paid_at', [$from, $to])
                ->sum('amount');

       return $totalPayment;
    }

    public function advanceReport(FeeType $feeType = null, $from = null, $to = null)
    {
        $from = $from?$from:AdvanceFeePayment::orderBy('paid_at', 'desc')->first()->created_at;
        $to = $to?$to:AdvanceFeePayment::orderBy('paid_at', 'asc')->first()->created_at;
       // $to = Carbon::createFromFormat('Y-m-d', $to)->addDay();

       if($feeType){
        $totalPayment = $this->advancePayments()
                ->where('fee_type_id', $feeType->id)
                ->whereBetween('paid_at', [$from, $to])
                ->sum('amount');
        return $totalPayment;
       }
       $totalPayment = $this->advancePayments()
                ->whereBetween('paid_at', [$from, $to])
                ->sum('amount');

       return $totalPayment;
    }
}

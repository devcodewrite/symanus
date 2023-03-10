<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes are mass assignable
     * @var array
     */
    protected $fillable = [
        'student_id', 'bdate', 'user_id', 'attendance_id'
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

    protected $appends = ['balance', 'status'];

    public function getBalanceAttribute()
    {
        return BillFee::join('bills', 'bills.id', '=', 'bill_fees.bill_id')
            ->where('bills.id', $this->id)
            ->leftJoin('payments', 'payments.bill_id', 'bills.id')
            ->selectRaw("SUM((CASE WHEN bill_fees.alt_amount IS NULL THEN bill_fees.amount - ifnull(payments.amount,0) ELSE bill_fees.alt_amount - ifnull(payments.amount,0) END)) as total")
            ->first()->total;
    }

    public function getStatusAttribute()
    {
    
        $balance = BillFee::join('bills', 'bills.id', '=', 'bill_fees.bill_id')
            ->where('bills.id', $this->id)
            ->leftJoin('payments', 'payments.bill_id', 'bills.id')
            ->selectRaw("SUM((CASE WHEN bill_fees.alt_amount IS NULL THEN bill_fees.amount - ifnull(payments.amount,0) ELSE bill_fees.alt_amount - ifnull(payments.amount,0) END)) as total")
            ->first()->total;
        $paid = $this->totalPayment();
        return $balance <= 0 ? 'Paid' : ($paid > 0?"Started":'Unpaid');
    }
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
     * Get the student that owns the fee.
     */
    public function guardian()
    {
        return $this->hasOneThrough(Guardian::class, Student::class);
    }

    /**
     * The fees that belong to the bill.
     */
    public function fees()
    {
        return $this->belongsToMany(Fee::class, 'bill_fees');
    }

    /**
     * The fees that belong to the bill for attendance only.
     */
    public function attendanceFees()
    {
        return $this->belongsToMany(Fee::class, 'bill_fees')
            ->join('fee_types', 'fee_types.id', '=', 'fees.fee_type_id')
            ->where('fee_types.for_attendance_bills', 1)
            ->get();
    }

    public function billFees()
    {
        return $this->hasMany(BillFee::class);
    }

    /**
     * Get the payments for the bill.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paidCount()
    {
        $count = 0;
        foreach (Bill::all() as $bill) {
            if ($bill->billFees() ->selectRaw("SUM((CASE WHEN bill_fees.alt_amount IS NULL THEN bill_fees.amount ELSE bill_fees.alt_amount END)) as total")
            ->first()->total - $bill->payments()->sum('amount') <= 0)
                $count++;
        }
        return $count;
    }

    public function paidCountByDate(string $date)
    {
        $count = 0;
        foreach (Bill::where('bdate', $date)->get() as $bill) {
            if ($bill->billFees()->selectRaw("SUM((CASE WHEN bill_fees.alt_amount IS NULL THEN bill_fees.amount ELSE bill_fees.alt_amount END)) as total")
            ->first()->total - $bill->payments()->sum('amount') <= 0)
                $count++;
        }
        return $count;
    }

    /**
     * Get the total bill amount for bill
     */

    public function totalAttendanceBill()
    {
        return
            $this->billFees()
            ->selectRaw("SUM((CASE WHEN bill_fees.alt_amount IS NULL THEN bill_fees.amount ELSE bill_fees.alt_amount END)) as total")
            ->first()
            ->total;
    }

    /**
     * Get the total bill amount for bill
     */

    public function totalBill()
    {
        return $this->billFees()
            ->selectRaw("SUM((CASE WHEN bill_fees.alt_amount IS NULL THEN bill_fees.amount ELSE bill_fees.alt_amount END)) as total")
            ->first()->total;
    }

    /**
     * Get the total payment amount for bill
     */

    public function totalPayment()
    {
        return $this->payments()->sum('amount');
    }
}

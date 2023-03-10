<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'studentid', 'firstname','class_id', 'surname', 'sex', 'address', 'dateofbirth', 'avatar',
        'rstate', 'admitted_at', 'transit', 'affiliation', 'linked_files', 'guardian_id',
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
     * Get the fees for the student.
     */
    public function fees()
    {
        return $this->hasMany(Fee::class, 'class_id');
    }

    /**
     * Get the bills for the student.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /**
    * The attendances that belong to the student.
    */
    public function attendances()
    {
        return $this->belongsToMany(Attendance::class, 'attendance_students');
    }

     /**
     * get Avatar for staff
     */
    public function getAvatar() :string
    {
        $imgs = [
            'male' => asset('img/man.png'),
            'female' => asset('img/woman.png'),
            'other' => asset('img/user.png')
        ];
        return $this->avatar?$this->avatar:$imgs[$this->sex];
    }

    public function getBalance(FeeType $feeType = null, $from = null, $to = null)
    {
        $billForDate = Bill::orderBy('bdate', 'asc')->first();
        $from = $from?$from:($billForDate?$billForDate->bdate:now('Africa/Accra')->format('Y-m-d'));
        $billForDate = Bill::orderBy('bdate', 'desc')->first();
        $to = $to?$to:($billForDate?$billForDate->bdate:now('Africa/Accra')->format('Y-m-d'));
       // $to = Carbon::createFromFormat('Y-m-d', $to)->addDay();

       if($feeType){
        $bills = $this->bills()->whereBetween('bdate', [$from, $to])->get();
        $totalBills = 0;
        foreach($bills as $bill){
            $totalBills += $bill->billFees()->join('fees', 'fees.id', '=', 'bill_fees.fee_id')
                    ->where('fee_type_id', $feeType->id)
                    ->sum('bill_fees.amount');
        }
        $totalPayment = $this->payments()
                ->where('fee_type_id', $feeType->id)
                ->whereBetween('paid_at', [$from, $to])
                ->sum('amount');
        return $totalBills - $totalPayment;
       }

       $bills = $this->bills()
                ->whereBetween('bdate', [$from, $to])
                ->get();
       $totalBills = 0;
       
       foreach($bills as $bill){
            $totalBills += $bill->billFees->sum('amount');
       }
       $totalPayment = $this->payments()
                ->whereBetween('paid_at', [$from, $to])
                ->sum('amount');

       return $totalBills-$totalPayment;
    }

    public function getBalanceByAttendance(int $attendance)
    {
        return $this->bills()
        ->join('bill_fees', 'bill_fees.bill_id', '=', 'bills.id')
        ->where('bills.attendance_id', $attendance)
        ->sum('bill_fees.amount');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','firstname', 'surname', 'phone', 'email', 'password','sex','avatar','user_role_id',
        'permission_id','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:d/m/y h:i a',
        'updated_at' => 'datetime:d/m/y h:i a',
    ];

    /**
     * Get the staff associated with the user.
     */
    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    /**
     * Get the guardian associated with the user.
     */
    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    /**
     * Get the user role that owns the user.
     */
    public function userRole()
    {
        return $this->belongsTo(UserRole::class,'user_role_id');
    }

    /**
     * Get the permission that owns the user.
     */
    public function permission()
    {
        if(!$this->belongsTo(Permission::class)->first()){
           return $this->userRole->permission();
        }
        return $this->belongsTo(Permission::class);
    }

    /**
     * get Avatar for user
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

    /**
     * Get the classes for the user.
     */
    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    /**
     * Get the payments for the user.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

     /**
     * Get the advance payments for the user.
     */
    public function advancePayments()
    {
        return $this->hasMany(AdvanceFeePayment::class);
    }
    /**
     * Get the bills for the class.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

     /**
     * Get the expenses for the class.
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
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
            $totalBills += $bill->fees()
                ->sum('amount');
        }
        return $totalBills;
    }

    public function expenseReport(ExpenseType $expenseType = null, $from = null, $to = null)
    {
        $from = $from ? $from : Expense::orderBy('edate', 'desc')->first()->bdate;
        $to = $to ? $to : Expense::orderBy('edate', 'asc')->first()->bdate;
      //  $to = Carbon::createFromFormat('Y-m-d', $to)->addDay();

        if ($expenseType) {
            return $this->expenses()
                    ->whereBetween('edate', [$from, $to])
                    ->whereIn('expense_type_id',[$expenseType->id])
                    ->sum('amount');
        }

      return $this->expenses()
            ->whereBetween('edate', [$from, $to])
            ->sum('amount');
    }

    public function advanceReport(FeeType $feeType = null, $from = null, $to = null)
    {
        $from = $from ? $from : Expense::orderBy('paid_at', 'desc')->first()->bdate;
        $to = $to ? $to : Expense::orderBy('paid_at', 'asc')->first()->bdate;
      //  $to = Carbon::createFromFormat('Y-m-d', $to)->addDay();

        if ($feeType) {
            return $this->advancePayments()
                    ->whereBetween('paid_at', [$from, $to])
                    ->whereIn('fee_type_id',[$feeType->id])
                    ->sum('amount');
        }

      return $this->advancePayments()
            ->whereBetween('paid_at', [$from, $to])
            ->sum('amount');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseReport extends Model
{
     /**
     * The attributes are mass assignable
     * @var array
     */
    protected $fillable = [
        'from_date', 'to_date','user_id','approval_user_id','status',
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
        'from_date' => 'datetime:d/m/y',
        'to_date' => 'datetime:d/m/y'
    ];
     /**
     * Get the approval user that owns the expense.
     */
    public function approvalUser()
    {
        return $this->belongsTo(User::class, 'approval_user_id');
    }

     /**
     * Get the user that owns the fee.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_report_id');
    }


    /**
     * Get the total bill amount for bill
     */

     public function totalExpense()
     {
        return $this->expenses()->sum('amount');
     }
}
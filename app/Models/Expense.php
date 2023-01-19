<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * The attributes are mass assignable
     * @var array
     */
    protected $fillable = [
        'description','user_id', 'expense_report_id', 'expense_type_id','amount','edate'
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
     * Get the expense type that owns the expense.
     */
    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }

     /**
     * Get the user that owns the fee.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

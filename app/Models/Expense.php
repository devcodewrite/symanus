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
        'description', 'class_id', 'rstatus', 'expense_type_id'
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
        return $this->belongsTo(FeeType::class, 'expense_type_id');
    }
}

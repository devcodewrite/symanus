<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'settings',
            'permissions',
            'modules',
            'user_roles',
            'users',
            'students',
            'guardians',
            'classes',
            'attendances',
            'fee_types',
            'fees',
            'expense_types',
            'expenses',
            'bills',
            'semesters',
            'staffs',
            'sms',
            'locked',
            'is_admin',
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'locked',
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
     * Get the users for the permission.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the userRoles for the permission.
     */
    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }
}

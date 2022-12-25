<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'permission_id'
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
    ];

    /**
    * Get the permission that owns the user role.
    */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * Get the users for the user role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

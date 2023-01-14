<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

     /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'staffid', 'title', 'firstname', 'surname', 'sex', 'address', 'salary', 'rstatus',
        'phone', 'mobile', 'email', 'linked_files', 'job_title', 'dateofbirth', 'avatar',
        'employed_at',
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
     * Get the user that owns the staff record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the classes for the staff.
     */
    public function classes()
    {
        return $this->hasMany(Classes::class);
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
}

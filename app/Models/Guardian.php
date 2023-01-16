<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Guardian extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'title', 'firstname', 'surname', 'sex', 'address', 'rstatus',
        'phone', 'mobile', 'email', 'linked_files', 'occupation', 'dateofbirth', 'avatar',
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
     * Get the user that owns the guardian record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the students for the guardian.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * get Avatar for guardian
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

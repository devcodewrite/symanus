<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value'
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

    public function getValue($key = '', $default='')
    {
        $data = $this->find($key);
        return $data?$data->value:$default;
    }

    public function setValue($key = null, $value='')
    {
        if(!$key) return;

        $data = $this->find($key);
        if($data){
            $data->value = $value;
            $data->save();
            return $data->value;
        }else {
            $this->key = $key;
            $this->value = $value;
            $this->save();
            return $this->value;
        }
    }
}

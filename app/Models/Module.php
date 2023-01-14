<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'locked' => 'boolean'
    ];


    public function hasModule(string $name = null)
    {
        if(!$name) return false;

        $module = $this->where('name',$name)->first();

        if(!$module) return false;

        if($module->status === 'enabled' || ($module->default_status === 'enabled' && $module->locked)){
            return true;
        }
        return false;
    }

    public function hasModuleGroup(string $label = null)
    {
        if(!$label) return false;

        $module = $this->where('group_label',$label)->where('status', 'enabled')->first();
        if(!$module) return false;
        return $module->count() > 0;
    }

    public function moduleGroup(string $label = null)
    {
        return $this->where('group_label',$label)->where('status', 'enabled')->get();
    }
}

<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return  in_array('view',explode(',',$user->permission->settings))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Setting $setting)
    {
        return  in_array('view',explode(',',$user->permission->settings))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        return  in_array('create',explode(',',$user->permission->settings))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Setting $setting)
    {
        //
        return  in_array('update',explode(',',$user->permission->settings))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Setting $setting)
    {
        //
       
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Setting $setting)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Setting $setting)
    {
        //
    }
}

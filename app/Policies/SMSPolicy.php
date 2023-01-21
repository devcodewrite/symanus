<?php

namespace App\Policies;

use App\Models\SMS;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SMSPolicy
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
        return  in_array('view',explode(',',$user->permission->sms))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SMS $sMS)
    {
        return  in_array('view',explode(',',$user->permission->sms))
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
        return  in_array('create',explode(',',$user->permission->sms))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SMS $sMS)
    {
        return  in_array('update',explode(',',$user->permission->sms))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SMS $sMS)
    {
        return  in_array('delete',explode(',',$user->permission->sms))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SMS $sMS)
    {
        return  in_array('restore',explode(',',$user->permission->sms))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SMS $sMS)
    {
        //
    }
}

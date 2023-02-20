<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AttendancePolicy
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
        return  in_array('view',explode(',',$user->permission->attendances))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Attendance $attendance)
    {
        return  in_array('view',explode(',',$user->permission->attendances))
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
        return  in_array('create',explode(',',$user->permission->attendances))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can create models for any class.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function createForAnyClass(User $user)
    {
        return $user->permission->is_admin
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Attendance $attendance)
    {
        return  in_array('update',explode(',',$user->permission->attendances))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Attendance $attendance)
    {
        return  in_array('delete',explode(',',$user->permission->attendances))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

     /**
     * Determine whether the user can report the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function report(User $user, Attendance $attendance)
    {
        return  in_array('report',explode(',',$user->permission->attendances))
        ?Response::allow():Response::deny("You don't have permission to view this model");
    }

    /**
     * Determine whether the user can report the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function approve(User $user, Attendance $attendance)
    {
        if($user->permission->is_admin){
            return Response::allow();
        }

        return  $attendance->approvalUser->id === $user->id
        ?Response::allow():Response::deny("You don't have permission to approve attendance");
    }
    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Attendance $attendance)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Attendance $attendance)
    {
        //
    }
}

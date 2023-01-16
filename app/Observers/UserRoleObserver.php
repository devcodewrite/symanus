<?php

namespace App\Observers;

use App\Models\Permission;
use App\Models\UserRole;

class UserRoleObserver
{
    /**
     * Handle the UserRole "created" event.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return void
     */
    public function created(UserRole $userRole)
    {
       
    }

    /**
     * Handle the UserRole "updated" event.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return void
     */
    public function updated(UserRole $userRole)
    {
        //
    }

    /**
     * Handle the UserRole "deleted" event.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return void
     */
    public function deleted(UserRole $userRole)
    {
        //
    }

    /**
     * Handle the UserRole "restored" event.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return void
     */
    public function restored(UserRole $userRole)
    {
        //
    }

    /**
     * Handle the UserRole "force deleted" event.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return void
     */
    public function forceDeleted(UserRole $userRole)
    {
        //
    }
}

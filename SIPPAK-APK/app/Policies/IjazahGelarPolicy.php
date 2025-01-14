<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\IjazahGelar;
use App\Models\Users;

class IjazahGelarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Users $users): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Users $users, IjazahGelar $ijazahGelar): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Users $users): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Users $users, IjazahGelar $ijazahGelar): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Users $users, IjazahGelar $ijazahGelar): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Users $users, IjazahGelar $ijazahGelar): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Users $users, IjazahGelar $ijazahGelar): bool
    {
        //
    }
}

<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\RekapCuti;
use App\Models\Users;

class RekapCutiPolicy
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
    public function view(Users $users, RekapCuti $rekapCuti): bool
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
    public function update(Users $users, RekapCuti $rekapCuti): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Users $users, RekapCuti $rekapCuti): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Users $users, RekapCuti $rekapCuti): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Users $users, RekapCuti $rekapCuti): bool
    {
        //
    }
}

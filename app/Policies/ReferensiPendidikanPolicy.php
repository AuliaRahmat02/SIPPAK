<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\referensi_pendidikan;
use App\Models\User;

class ReferensiPendidikanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, referensi_pendidikan $referensiPendidikan): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, referensi_pendidikan $referensiPendidikan): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, referensi_pendidikan $referensiPendidikan): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, referensi_pendidikan $referensiPendidikan): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, referensi_pendidikan $referensiPendidikan): bool
    {
        //
    }
}

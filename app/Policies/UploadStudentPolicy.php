<?php

namespace App\Policies;

use App\Models\UploadStudent;
use App\Models\verified;
use Illuminate\Auth\Access\Response;

class UploadStudentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(verified $verified): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(verified $verified, UploadStudent $uploadStudent): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(verified $verified): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(verified $verified, UploadStudent $uploadStudent): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(verified $verified, UploadStudent $uploadStudent): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(verified $verified, UploadStudent $uploadStudent): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(verified $verified, UploadStudent $uploadStudent): bool
    {
        //
    }
}

<?php

namespace App\Policies;

use App\Models\Link;
use App\Models\User;

class LinkPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Link $link): bool
    {
        return $link->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Link $link): bool
    {
        return $link->user_id === $user->id;
    }

    /**
     * Determine whether the user can toggle the model's active state.
     */
    public function toggle(User $user, Link $link): bool
    {
        return $link->user_id === $user->id;
    }
}

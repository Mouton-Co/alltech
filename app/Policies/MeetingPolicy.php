<?php

namespace App\Policies;

use App\Models\Meeting;
use App\Models\User;

class MeetingPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Meeting $model): bool
    {
        return $user->role->name === 'Admin' ||
            $user->id === $model->user->id;
    }
}

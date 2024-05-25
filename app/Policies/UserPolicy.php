<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        //return $user->hasRole('admin') || $user->hasRole('superadmin');
    }

    public function manageSuperadmin(User $user)
    {
        //return $user->hasRole('superadmin');
    }

    public function viewAny(User $user)
    {
        // Logic to authorize viewing all users
    }

    public function view(User $user, User $targetUser)
    {
        // Logic to authorize viewing a specific user
    }

    public function create(User $user)
    {
        // Logic to authorize creating a new user
    }

    public function update(User $user, User $targetUser)
    {
        // Logic to authorize updating a user
        return $user->hasRoles('superadmin') || ($user->hasRoles('admin') && !$targetUser->hasRoles('superadmin'));
    }

    public function delete(User $user, User $targetUser)
    {
        // Logic to authorize deleting a user
        return $user->hasRoles('superadmin') || ($user->hasRoles('admin') && !$targetUser->hasRoles('superadmin'));
    }

}

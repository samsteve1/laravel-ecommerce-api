<?php

namespace App\Policies;

use App\User;
use App\Traits\AdminRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization, AdminRole;

    
    public function view(User $authenticatedUser, User $user)
    {
        return $authenticatedUser->id === $user->id;
    }


    
    public function update(User $authenticatedUser, User $user)
    {
        return $authenticatedUser->id === $user->id;
    }

   
    public function delete(User $authenticatedUser, User $user)
    {

        return $authenticatedUser->id === $user->id && $authenticatedUser->token()->client->personal_access_client;
        
    }
   
}

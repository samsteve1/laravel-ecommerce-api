<?php

namespace App\Policies;

use App\User;
use App\Seller;
use App\Traits\AdminRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
{
    use HandlesAuthorization, AdminRole;

   
    
    public function view(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    
    
    public function sale(User $user, User $seller)
    {
        return $user->id === $seller->id;
    }

    public function editProduct(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    public function deleteProduct(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }
    
}

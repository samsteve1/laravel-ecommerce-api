<?php

namespace App\Policies;

use App\User;
use App\Product;
use App\Traits\AdminRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization, AdminRole;

    public function addCategory(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }

    public function deleteCategory(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }
}

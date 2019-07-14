<?php

namespace App\Policies;

use App\User;
use App\Transaction;
use App\Traits\AdminRole
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization, AdminRole;

    /**
     * Determine whether the user can view the transaction.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function view(User $user, Transaction $transaction)
    {
       return $user->id === $transaction->user_id || $user->id === $transaction->product->user_id;
    }

  
}

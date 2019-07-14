<?php
namespace App\Traits;

trait AdminRole
{
    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
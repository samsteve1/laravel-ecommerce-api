<?php

namespace App;

use App\User;
use App\Transformers\SellerTransformer;
use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Model;


class Seller extends User
{
    public $transformer = SellerTransformer::class;
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SellerScope);
    }
}

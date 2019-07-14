<?php

namespace App;

use App\User;
use App\Scopes\BuyerScope;
use App\Transformers\BuyerTransformer;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{
    public $transformer = BuyerTransformer::class;
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BuyerScope);
    }
    
    protected $table = 'users';
}

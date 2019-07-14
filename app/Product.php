<?php

namespace App;

use App\User;
use App\Category;
use App\Transaction;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    public $transformer = ProductTransformer::class;
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'available',
        'image',
        'user_id',
        'category_id',
    ];

    public function isAvailable()
    {
        return $this->available;
    }

    public function isNotAvailable()
    {
        return !$this->isAvailable();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}


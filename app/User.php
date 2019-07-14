<?php

namespace App;

use App\Role;
use App\Transaction;
use App\Transformers\UserTransformer;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    public $transformer = UserTransformer::class;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'role_id',
        'verified',
        'verification_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'verification_token',
    ];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function isVerified()
    {
        return $this->verified;
    }
    public function isAdmin()
    {
        return strtolower($this->role->name) === 'admin';
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public static function generateVerificationCode()
    {
        return str_random(40);
    }

    public static function getVerified()
    {
        return false;
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }
}

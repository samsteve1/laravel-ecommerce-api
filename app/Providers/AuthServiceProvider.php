<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Buyer' => 'App\Policies\BuyerPolicy',
        'App\Seller' => 'App\Policies\SellerPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Transaction' => 'App\Policies\TransactionPolicy',
        'App\Product' => 'App\Policies\ProductPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-action', function ($user) {
            
            return $user->isAdmin();
        });

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(60));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();

        Passport::tokensCan([
            'purchase-products'     =>  'Create a new transaction for a product',
            'manage-products'       =>  'Create, read, update and delete products',
            'manage-account'        =>  'Read your account data, cannot dedlete your account.',
            'read-general'          =>  'Read general information'
        ]);
    }
}

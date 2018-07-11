<?php

namespace App\Providers;

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
        'App\Permission' => 'App\Policies\PermissionPolicy',
        'App\Role'       => 'App\Policies\RolePolicy',
        'App\Team'       => 'App\Policies\TeamPolicy',
        'App\User'       => 'App\Policies\UserPolicy',
        'App\Shift'       => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        // Passport::tokensExpireIn(now()->addHours(1));
        // Passport::refreshTokensExpireIn(now()->addHours(1)->addMinutes(15));
    }
}

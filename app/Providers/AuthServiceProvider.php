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
        \App\AdditionalField::class => \App\Policies\AdditionalFieldPolicy::class,
        \App\Permission::class      => \App\Policies\PermissionPolicy::class,
        \App\Role::class            => \App\Policies\RolePolicy::class,
        \App\Team::class            => \App\Policies\TeamPolicy::class,
        \App\User::class            => \App\Policies\UserPolicy::class,
        \App\Shift::class           => \App\Policies\UserPolicy::class,
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

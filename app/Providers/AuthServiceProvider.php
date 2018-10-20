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
        \App\AdditionalField::class => \App\Policies\BasePolicy::class,
        \App\Permission::class      => \App\Policies\BasePolicy::class,
        \App\Role::class            => \App\Policies\BasePolicy::class,
        \App\Team::class            => \App\Policies\BasePolicy::class,
        \App\User::class            => \App\Policies\BasePolicy::class,
        \App\Shift::class           => \App\Policies\BasePolicy::class,
        \App\DoNotDisturb::class    => \App\Policies\BasePolicy::class,
        \App\Location::class        => \App\Policies\BasePolicy::class,
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

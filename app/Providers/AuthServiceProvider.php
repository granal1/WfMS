<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Roles\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         'App\Models\Documents\Document' => 'App\Policies\Documents\DocumentPolicy',
        'App\Models\Admin\Admin' => 'App\Policies\Admin\AdminPolicy',
        'App\Models\User' => 'App\Policies\Users\UserPolicy',
        'App\Models\Roles\Role' => 'App\Policies\Roles\RolePolicy',
        'App\Models\Profile\Profile' => 'App\Policies\Profile\ProfilePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Policy section
        $policies = 'App\Policies\\';
        Gate::define('comments.view', $policies . 'CommentPolicy@view');
        Gate::define('comments.create', $policies . 'CommentPolicy@create');
        Gate::define('comments.update', $policies . 'CommentPolicy@update');
        Gate::define('comments.delete', $policies . 'CommentPolicy@delete');

        Gate::define('inks.view', $policies . 'InkPolicy@view');
        Gate::define('inks.create', $policies . 'InkPolicy@create');
        Gate::define('inks.update', $policies . 'InkPolicy@update');
        Gate::define('inks.delete', $policies . 'InkPolicy@delete');

        Gate::define('likes.create', $policies . 'LikePolicy@create');
        Gate::define('likes.delete', $policies . 'LikePolicy@delete');

        Passport::routes();
    }
}

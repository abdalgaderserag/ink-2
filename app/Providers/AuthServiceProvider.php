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
        Gate::define('comments.view', 'CommentPolicy@view');
        Gate::define('comments.create', 'CommentPolicy@create');
        Gate::define('comments.update', 'CommentPolicy@update');
        Gate::define('comments.delete', 'CommentPolicy@delete');

        Gate::define('inks.view', 'InkPolicy@view');
        Gate::define('inks.create', 'InkPolicy@create');
        Gate::define('inks.update', 'InkPolicy@update');
        Gate::define('inks.delete', 'InkPolicy@delete');

        Gate::define('likes.view', 'LikePolicy@view');
        Gate::define('likes.create', 'LikePolicy@create');
        Gate::define('likes.delete', 'LikePolicy@delete');

        Gate::define('medias.view', 'MediaPolicy@view');
        Gate::define('medias.create', 'MediaPolicy@create');
        Gate::define('medias.update', 'MediaPolicy@update');
        Gate::define('medias.delete', 'MediaPolicy@delete');


        Passport::routes();
    }
}

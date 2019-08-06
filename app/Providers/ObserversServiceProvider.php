<?php

namespace App\Providers;

use App\Comment;
use App\Ink;
use App\Like;
use App\Media;
use App\Observers\CommentObserver;
use App\Observers\InkObserver;
use App\Observers\LikeObserver;
use App\Observers\MediaObserver;
use App\Observers\UserObserver;
use App\User;
use Illuminate\Support\ServiceProvider;


class ObserversServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Comment::observe(CommentObserver::class);
        Ink::observe(InkObserver::class);
        Media::observe(MediaObserver::class);
        User::observe(UserObserver::class);
        Like::observe(LikeObserver::class);
    }
}

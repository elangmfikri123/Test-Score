<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\Session::extend('database', function ($app) {
            return new \Illuminate\Session\DatabaseSessionHandler(
                $app['db']->connection(),
                'sessions',
                $app['config']['session.lifetime'],
                $app
            );
        });
    
        \Illuminate\Support\Facades\Event::listen('Illuminate\Session\Events\SessionStarted', function () {
            if (Auth::check()) {
                DB::table('sessions')->where('id', Session::getId())->update(['user_id' => Auth::id()]);
            }
        });
    }
}

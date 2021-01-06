<?php

namespace App\Providers;

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
        // diz pro lumen usar o JWT
        $this->app->register(\Tymon\JWTAuth\Providers\LumenServiceProvider::class);
    }
}

<?php

namespace EvoFone;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class FoneEvoServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(FoneEvoManager::class, function ($app) {
            return new FoneEvoManager($app['config']->get('services.forge.token'));
        });
    }
}

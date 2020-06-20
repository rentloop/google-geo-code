<?php

namespace Tjefford\GoogleGeoCode;

use Illuminate\Support\ServiceProvider;

class GoogleGeoCodeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Tjefford\GoogleGeoCode\Lookup');
    }
}

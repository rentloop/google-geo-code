<?php

namespace Rentloop\GoogleGeoCode;

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
        $this->app->make('Rentloop\GoogleGeoCode\Lookup');
    }
}

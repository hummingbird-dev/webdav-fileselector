<?php

namespace HummingbirdDev\WebdavFileselector;

use Illuminate\Support\ServiceProvider;

class WebdavFileselectorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'webdav-fileselector');

        //copy views
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/hummingbird-dev/webdav-fileselector'),
        ]);

        //copy js
        $this->publishes([
            __DIR__.'/js' => public_path('hummingbird-dev/webdav-fileselector'),
        ]);

        //copy css
        $this->publishes([
            __DIR__.'/css' => public_path('hummingbird-dev/webdav-fileselector'),
        ]);

        //copy vendor
        $this->publishes([
            __DIR__.'/vendor' => public_path('hummingbird-dev/webdav-fileselector'),
        ]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes/web.php';
        $this->app->make('HummingbirdDev\WebdavFileselector\WebdavFileselectorController');
    }
}

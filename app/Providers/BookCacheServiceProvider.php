<?php

namespace App\Providers;

use App\Services\BookCacheService;
use Illuminate\Support\ServiceProvider;

class BookCacheServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        // Bind the BookCacheService into the container
        $this->app->singleton(BookCacheService::class, function () {
            return new BookCacheService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }
}
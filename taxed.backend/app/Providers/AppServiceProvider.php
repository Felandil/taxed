<?php

namespace App\Providers;

use App\Repository\TaxedSQLiteRepository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        $this->app->singleton(TaxedSQLiteRepository::class, function ($app) {
            return new TaxedSQLiteRepository($app->make(DatabaseManager::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

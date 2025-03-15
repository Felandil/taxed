<?php

namespace App\Providers;

use App\Repository\TaxedSQLiteRepository;
use App\Services\DepreciationCalculator;
use App\Services\IDepreciationCalculator;
use Carbon\Carbon;
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

        $this->app->singleton(IDepreciationCalculator::class, function ($app) {
            return new DepreciationCalculator(Carbon::parse('01.10.2021'), Carbon::parse('30.09.2021'));
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

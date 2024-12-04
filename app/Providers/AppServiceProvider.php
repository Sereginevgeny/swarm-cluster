<?php

namespace App\Providers;

use App\Service\PollManageService;
use App\Service\PollSummaryService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PollSummaryService::class, function () {
            return new PollSummaryService(
                $this->app->make(PollManageService::class),
                $this->app->make('redis')->connection('default'),
                $this->app->make(LoggerInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('id', '[0-9]+');
    }
}

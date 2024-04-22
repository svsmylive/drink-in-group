<?php

namespace App\Providers;

use App\Contracts\Services\PaymentInterface;
use App\Models\Institution;
use App\Observers\InstitutionObserver;
use App\Services\YookassaService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentInterface::class, YookassaService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Institution::observe(InstitutionObserver::class);
    }
}

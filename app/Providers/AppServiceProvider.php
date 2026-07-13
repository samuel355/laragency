<?php

namespace App\Providers;

use App\Models\Inquiry;
use App\Models\MortgageApplication;
use App\Models\SiteVisit;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('layouts.admin', function ($view): void {
            $view->with('newLeadsCount',
                Inquiry::where('status', 'new')->count()
                + SiteVisit::where('status', 'requested')->count()
                + MortgageApplication::where('status', 'new')->count()
            );
        });
    }
}

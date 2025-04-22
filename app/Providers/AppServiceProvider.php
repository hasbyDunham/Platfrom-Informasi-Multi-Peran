<?php

namespace App\Providers;

use App\Models\Categorie;
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
        // Memberikan data kategori ke semua view
        View::composer('*', function ($view) {
            $view->with('categories', Categorie::all());
        });
    }
}

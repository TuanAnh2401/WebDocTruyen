<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Price;
use App\Models\Genre;
use App\Models\Slide;
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
    public function boot()
    {
        View::composer('*', function ($view) {
            $prices = Price::all();
            $genres = Genre::all();
            $slides = Slide::all();
            $view->with(['prices' => $prices, 'genres' => $genres,'slides'=>$slides]);
        });
    }
}

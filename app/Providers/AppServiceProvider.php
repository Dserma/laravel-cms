<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.UTF-8', 'pt_BR.utf8', 'portuguese');
        $faker = \Faker\Factory::create('pt_BR');
        require_once app_path('Macros/Functions.php');
        $url = $this->app['url'];
        $url->forceRootUrl(config('app.url'));
        Carbon::setLocale('pt_BR');
    }
}

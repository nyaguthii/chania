<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\AfricasTalkingGateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AfricasTalkingGateway::class,function(){
            return new AfricasTalkingGateway(config('services.sms.username'),config('services.sms.key'),config('services.sms.environment'));
        });
    }
}

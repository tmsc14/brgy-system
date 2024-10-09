<?php

namespace App\Providers;

use App\Services\LocationService;
use App\View\Components\ContentContainer;
use App\View\Components\IconLongButton;
use App\View\Components\IconHeader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LocationService::class, function ($app) {
            return new LocationService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('icon-long-button', IconLongButton::class);
        Blade::component('icon-header', IconHeader::class);
        Blade::component('content-container', ContentContainer::class);

        Validator::extend('alpha_spaces', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[\pL\s]+$/u', $value);
        });
    
        Validator::replacer('alpha_spaces', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute must only contain letters and spaces.');
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AppearanceSetting;
use Illuminate\Support\Facades\Auth;

class AppearanceSettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $barangayId = Auth::user()->barangay_id ?? null;
            
            if ($barangayId) {
                $appearanceSettings = AppearanceSetting::where('barangay_id', $barangayId)->first();
                $view->with('appearanceSettings', $appearanceSettings);
            }
        });
    }

    public function register()
    {
        //
    }
}

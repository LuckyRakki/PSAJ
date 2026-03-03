<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // BAGIKAN SETTINGS KE SEMUA VIEW
        // Cek dulu apakah tabel settings ada agar tidak error saat migrate fresh
        if (Schema::hasTable('settings')) {
            $settings = Setting::all()->pluck('value', 'key');
            View::share('app_settings', $settings);
        }
    }
}
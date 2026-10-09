<?php

namespace App\Providers;

use App\Models\Setting;
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
        // Jika tabel setting masih kosong, pakai nilai default agar halaman tidak error
        $setting = function () {
            return Setting::first() ?? (new Setting())->forceFill([
                'nama_perusahaan' => config('app.name', 'Buku Kunjungan Sales'),
                'alamat'          => '',
                'telepon'         => '',
                'path_logo'       => '/img/logo.png',
            ]);
        };

        view()->composer('layouts.master', function ($view) use ($setting) {
            $view->with('setting', $setting());
        });
        view()->composer('layouts.auth', function ($view) use ($setting) {
            $view->with('setting', $setting());
        });
        view()->composer('auth.login', function ($view) use ($setting) {
            $view->with('setting', $setting());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

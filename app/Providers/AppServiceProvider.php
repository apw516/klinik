<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon; // Pastikan ini di-import jika ingin mengatur makro Carbon
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
        date_default_timezone_set('Asia/Jakarta');

        // Memaksa Carbon mengikuti timezone PHP runtime secara berkala
        Carbon::setLocale('id'); // Opsional: Mengubah nama hari/bulan Carbon jadi Bahasa Indonesia
    }
}

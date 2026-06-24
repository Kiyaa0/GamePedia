<?php

namespace App\Providers;

use App\Models\User;
use App\Services\RawgService;
use App\Services\SteamService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RawgService::class, function () {
            return new RawgService(
                baseUrl: config('services.rawg.base_url'),
                apiKey: config('services.rawg.key'),
            );
        });

        $this->app->singleton(SteamService::class, function () {
            return new SteamService(
                apiKey: config('services.steam.key'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', fn (User $user) => $user->role === 'admin');
    }
}

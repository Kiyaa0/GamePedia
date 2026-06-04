<?php

namespace App\Providers;

use App\Models\User;
use App\Services\RawgService;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', fn (User $user) => $user->role === 'admin');
    }
}

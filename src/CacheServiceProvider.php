<?php

namespace RGout\PassportCache;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;
use RGout\PassportCache\Repositories\CacheClientRepository;
use RGout\PassportCache\Repositories\CacheRefreshTokenRepository;
use RGout\PassportCache\Repositories\CacheTokenRepository;

class CacheServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TokenRepository::class, function () {
            return new CacheTokenRepository();
        });

        $this->app->singleton(RefreshTokenRepository::class, function () {
            return new CacheRefreshTokenRepository();
        });

        $this->app->singleton(ClientRepository::class, function () {
            return new CacheClientRepository();
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/passport-cache.php' => config_path('passport-cache.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/passport-cache.php', 'passport-cache'
        );
    }
}

<?php

namespace RGout\PassportCache;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

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
    }
}
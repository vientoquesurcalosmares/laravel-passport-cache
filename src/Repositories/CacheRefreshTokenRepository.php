<?php

namespace RGout\PassportCache\Repositories;

use Laravel\Passport\Passport;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\RefreshTokenRepository;

class CacheRefreshTokenRepository extends RefreshTokenRepository
{
    private string $cacheKey = 'passport:refresh-token';
    private int $cacheTtl;

    public function __construct()
    {
        $this->cacheTtl = (int)config('passport-cache.refresh_token_ttl', 60);
    }

    public function find($id): ?RefreshToken
    {
        return cache()
            ->remember(
                $this->createKey($id),
                $this->cacheTtl,
                fn() => parent::find($id)
            );
    }

    public function revokeRefreshToken($id): void
    {
        cache()->forget($this->createKey($id));

        parent::revokeRefreshToken($id);
    }

    public function revokeRefreshTokensByAccessTokenId($tokenId): void
    {
        Passport::refreshToken()
            ->query()
            ->where('access_token_id', $tokenId)
            ->get()
            ->each(fn(RefreshToken $token) => cache()->forget($this->createKey($token->id)));

        parent::revokeRefreshTokensByAccessTokenId($tokenId);
    }

    protected function createKey($id): string
    {
        return sprintf('%s:%s', $this->cacheKey, $id);
    }
}

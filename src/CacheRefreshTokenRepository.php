<?php

namespace RGout\PassportCache;

use Laravel\Passport\Passport;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\RefreshTokenRepository;

class CacheRefreshTokenRepository extends RefreshTokenRepository
{
    public function __construct(
        public readonly string $prefixKey = 'passport:refresh-token',
        public readonly int $cacheTtl = 60,
    ) {
    }

    public function find($id): ?RefreshToken
    {
        return cache()
            ->remember(
                $this->createKey($id),
                $this->cacheTtl,
                fn () => parent::find($id)
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
            ->each(fn (RefreshToken $token) => cache()->forget($this->createKey($token->id)));

        parent::revokeRefreshTokensByAccessTokenId($tokenId);
    }

    protected function createKey($id): string
    {
        return sprintf('%s:%s', $this->prefixKey, $id);
    }
}
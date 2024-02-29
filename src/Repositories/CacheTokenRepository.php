<?php

namespace RGout\PassportCache\Repositories;

use Illuminate\Support\Collection;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;

class CacheTokenRepository extends TokenRepository
{
    private string $cacheKey;
    private int $cacheTtl;

    public function __construct()
    {
        $this->cacheKey = 'passport:token';
        $this->cacheTtl = (int)config('passport-cache.token_ttl', 60);
    }

    public function find($id): ?Token
    {
        return cache()
            ->remember(
                $this->createKey($id),
                $this->cacheTtl,
                fn() => parent::find($id)
            );
    }

    public function findForUser($id, $userId): ?Token
    {
        return cache()
            ->remember(
                $this->createKey($id),
                $this->cacheTtl,
                fn() => parent::findForUser($id, $userId)
            );
    }

    public function forUser($userId): Collection
    {
        return cache()
            ->remember(
                $this->createKey($userId),
                $this->cacheTtl,
                fn() => parent::forUser($userId)
            );
    }

    public function getValidToken($user, $client): ?Token
    {
        return cache()
            ->remember(
                $this->createKey($user->getKey() . $client->getKey()),
                $this->cacheTtl,
                fn() => parent::getValidToken($user, $client)
            );
    }

    public function revokeAccessToken($id): mixed
    {
        cache()->forget($this->createKey($id));

        return parent::revokeAccessToken($id);
    }

    protected function createKey($id): string
    {
        return sprintf('%s:%s', $this->cacheKey, $id);
    }
}

<?php

namespace RGout\PassportCache;

use Illuminate\Support\Collection;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;

class CacheTokenRepository extends TokenRepository
{
    public function __construct(
        public readonly string $prefixKey = 'passport:token',
        public readonly int $cacheTtl = 60,
    ) {
    }

    public function find($id): ?Token
    {
        return cache()
            ->remember(
                $this->createKey($id),
                $this->cacheTtl,
                fn () => parent::find($id)
            );
    }

    public function findForUser($id, $userId): ?Token
    {
        return cache()
            ->remember(
                $this->createKey($id),
                $this->cacheTtl,
                fn () => parent::findForUser($id, $userId)
            );
    }

    public function forUser($userId): Collection
    {
        return cache()
            ->remember(
                $this->createKey($userId),
                $this->cacheTtl,
                fn () => parent::forUser($userId)
            );
    }

    public function getValidToken($user, $client): ?Token
    {
        return cache()
            ->remember(
                $this->createKey($user->getKey() . $client->getKey()),
                $this->cacheTtl,
                fn () => parent::getValidToken($user, $client)
            );
    }

    public function revokeAccessToken($id)
    {
        cache()->forget($this->createKey($id));

        parent::revokeAccessToken($id);
    }

    protected function createKey($id): string
    {
        return sprintf('%s:%s', $this->prefixKey, $id);
    }
}
<?php

namespace RGout\PassportCache\Repositories;

use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;

class CacheClientRepository extends ClientRepository
{
    private string $cacheKey;
    private int $cacheTtl;

    public function __construct($personalAccessClientId = null, $personalAccessClientSecret = null)
    {
        $this->cacheKey = 'passport:client-token';
        $this->cacheTtl = (int)config('passport-cache.client_ttl', 300);

        parent::__construct($personalAccessClientId, $personalAccessClientSecret);
    }

    public function find($id): ?Client
    {
        return cache()
            ->remember(
                $this->createKey($id),
                $this->cacheTtl,
                fn() => parent::find($id)
            );
    }

    protected function createKey($id): string
    {
        return sprintf('%s:%s', $this->cacheKey, $id);
    }
}

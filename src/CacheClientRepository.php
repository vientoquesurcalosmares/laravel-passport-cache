<?php

namespace RGout\PassportCache;

use Illuminate\Support\Collection;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;

class CacheClientRepository extends ClientRepository
{
    /**
     * Cache this value a little longer because it's used for every request.
     * And it is unlikely to become revoked.
     */
    protected int $cacheTtl = 300;

    public function find($id): ?Token
    {
        return cache()
            ->remember(
                $this->createKey($id),
                $this->cacheTtl,
                fn () => parent::find($id)
            );
    }

    protected function createKey($id): string
    {
        return sprintf('%s:%s', 'passport:client-token', $id);
    }
}
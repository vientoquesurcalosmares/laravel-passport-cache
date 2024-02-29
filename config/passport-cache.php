<?php

return [
    /**
     * Client cache time to live in seconds.
     *
     * Cache this value a little longer because it's used for every request.
     * And it is unlikely to become revoked.
     */
    'client_ttl' => 300,

    /**
     * Token cache time to live in seconds.
     */
    'token_ttl' => 60,

    /**
     * Refresh token cache time to live in seconds.
     */
    'refresh_token_ttl' => 60,
];

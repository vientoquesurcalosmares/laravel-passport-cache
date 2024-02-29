# Laravel Passport Cache

This package provides a seamless caching layer for Laravel Passport, enhancing the performance of OAuth2 operations by caching access tokens, clients, and personal access tokens. It's designed for applications using Laravel Passport for authentication, aiming to reduce database load and improve response times.

## Installation

You can install the package via composer:

```bash
composer require rdgout/laravel-passport-cache
```

## Configuration

Publish the package configuration to customize cache settings:

```bash
php artisan vendor:publish --provider="RGout\LaravelPassportCache\CacheServiceProvider"
```

This command publishes a configuration file to `config/passport-cache.php`, where you can adjust the cache settings.

## Usage

Once installed, the package automatically hooks into Laravel Passport's existing mechanisms. No further action is required for basic caching functionality.

To customize the caching behavior or to manually cache items, refer to the documentation below.

### Customizing Cache Times

#### `client_ttl`

- **Description**: Sets the cache time to live (TTL) for OAuth clients in seconds.
- **Default**: `300` seconds.
- **Why Customize**: This value is used for every request involving client details. Since OAuth client details are less likely to change frequently, caching them for a slightly longer duration can improve performance without significantly increasing the risk of stale data.

#### `token_ttl`

- **Description**: Sets the cache TTL for access tokens in seconds.
- **Default**: `60` seconds.
- **Why Customize**: Access tokens are frequently validated in your application. Setting an appropriate TTL can help reduce database load by caching token validation responses.

#### `refresh_token_ttl`

- **Description**: Sets the cache TTL for refresh tokens in seconds.
- **Default**: `60` seconds.
- **Why Customize**: Similar to access tokens, caching refresh tokens can improve the efficiency of token refresh operations. Consider adjusting this value based on your application's security requirements and refresh token usage patterns.

By customizing these settings, you can tailor the caching behavior of Laravel Passport to match the specific needs and traffic patterns of your application, balancing performance improvements with data freshness and security considerations.

### Clearing Cache

There is no specific command to clear the cache for Laravel Passport.
Instead, you can use Laravel's built-in cache clearing commands to clear the cache for Laravel Passport Cache:

```bash
php artisan cache:clear
```

## Security

If you discover any security-related issues, please use the issue tracker.

## Contributing

Contributions are welcome but please ensure to follow the [contributing guidelines](CONTRIBUTING.md). 

## License

The Laravel Passport Cache is open-sourced software licensed under the [MIT license](LICENSE.md).

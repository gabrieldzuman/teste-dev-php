<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache store that will be used by the
    | framework. This connection is utilized if another isn't explicitly
    | specified when running a cache operation inside the application.
    |
    */

    'default' => env(key: 'CACHE_STORE', default: 'database'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    | Supported drivers: "array", "database", "file", "memcached",
    |                    "redis", "dynamodb", "octane", "null"
    |
    */

    'stores' => [

        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        'database' => [
            'driver' => 'database',
            'connection' => env(key: 'DB_CACHE_CONNECTION'),
            'table' => env(key: 'DB_CACHE_TABLE', default: 'cache'),
            'lock_connection' => env(key: 'DB_CACHE_LOCK_CONNECTION'),
            'lock_table' => env(key: 'DB_CACHE_LOCK_TABLE'),
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path(path: 'framework/cache/data'),
            'lock_path' => storage_path(path: 'framework/cache/data'),
        ],

        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env(key: 'MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env(key: 'MEMCACHED_USERNAME'),
                env(key: 'MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            'servers' => [
                [
                    'host' => env(key: 'MEMCACHED_HOST', default: '127.0.0.1'),
                    'port' => env(key: 'MEMCACHED_PORT', default: 11211),
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => env(key: 'REDIS_CACHE_CONNECTION', default: 'cache'),
            'lock_connection' => env(key: 'REDIS_CACHE_LOCK_CONNECTION', default: 'default'),
        ],

        'dynamodb' => [
            'driver' => 'dynamodb',
            'key' => env(key: 'AWS_ACCESS_KEY_ID'),
            'secret' => env(key: 'AWS_SECRET_ACCESS_KEY'),
            'region' => env(key: 'AWS_DEFAULT_REGION', default: 'us-east-1'),
            'table' => env(key: 'DYNAMODB_CACHE_TABLE', default: 'cache'),
            'endpoint' => env(key: 'DYNAMODB_ENDPOINT'),
        ],

        'octane' => [
            'driver' => 'octane',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing the APC, database, memcached, Redis, and DynamoDB cache
    | stores, there might be other applications using the same cache. For
    | that reason, you may prefix every cache key to avoid collisions.
    |
    */

    'prefix' => env(key: 'CACHE_PREFIX', default: Str::slug(title: env(key: 'APP_NAME', default: 'laravel'), separator: '_').'_cache_'),

];

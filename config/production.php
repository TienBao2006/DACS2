<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Production Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options specifically for production
    | environment to optimize performance and security.
    |
    */

    'optimizations' => [
        'config_cache' => true,
        'route_cache' => true,
        'view_cache' => true,
        'event_cache' => true,
    ],

    'security' => [
        'force_https' => env('FORCE_HTTPS', true),
        'hsts_max_age' => 31536000, // 1 year
        'content_security_policy' => [
            'default-src' => "'self'",
            'script-src' => "'self' 'unsafe-inline' 'unsafe-eval'",
            'style-src' => "'self' 'unsafe-inline'",
            'img-src' => "'self' data: https:",
            'font-src' => "'self'",
            'connect-src' => "'self'",
            'media-src' => "'self'",
            'object-src' => "'none'",
            'child-src' => "'self'",
            'frame-ancestors' => "'none'",
            'form-action' => "'self'",
            'base-uri' => "'self'",
        ],
    ],

    'performance' => [
        'gzip_compression' => true,
        'browser_cache_ttl' => 31536000, // 1 year for static assets
        'database_query_log' => false,
        'slow_query_threshold' => 1000, // ms
    ],

    'monitoring' => [
        'error_reporting' => false,
        'log_level' => 'error',
        'log_max_files' => 30,
        'log_daily' => true,
    ],
];
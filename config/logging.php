<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that is utilized to write
    | messages to your logs. The value provided here should match one of
    | the channels present in the list of "channels" configured below.
    |
    */

    'default' => env(key: 'LOG_CHANNEL', default: 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => [
        'channel' => env(key: 'LOG_DEPRECATIONS_CHANNEL', default: 'null'),
        'trace' => env(key: 'LOG_DEPRECATIONS_TRACE', default: false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Laravel
    | utilizes the Monolog PHP logging library, which includes a variety
    | of powerful log handlers and formatters that you're free to use.
    |
    | Available drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog", "custom", "stack"
    |
    */

    'channels' => [

        'stack' => [
            'driver' => 'stack',
            'channels' => explode(separator: ',', string: env(key: 'LOG_STACK', default: 'single')),
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path(path: 'logs/laravel.log'),
            'level' => env(key: 'LOG_LEVEL', default: 'debug'),
            'replace_placeholders' => true,
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path(path: 'logs/laravel.log'),
            'level' => env(key: 'LOG_LEVEL', default: 'debug'),
            'days' => env(key: 'LOG_DAILY_DAYS', default: 14),
            'replace_placeholders' => true,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env(key: 'LOG_SLACK_WEBHOOK_URL'),
            'username' => env(key: 'LOG_SLACK_USERNAME', default: 'Laravel Log'),
            'emoji' => env(key: 'LOG_SLACK_EMOJI', default: ':boom:'),
            'level' => env(key: 'LOG_LEVEL', default: 'critical'),
            'replace_placeholders' => true,
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env(key: 'LOG_LEVEL', default: 'debug'),
            'handler' => env(key: 'LOG_PAPERTRAIL_HANDLER', default: SyslogUdpHandler::class),
            'handler_with' => [
                'host' => env(key: 'PAPERTRAIL_URL'),
                'port' => env(key: 'PAPERTRAIL_PORT'),
                'connectionString' => 'tls://'.env(key: 'PAPERTRAIL_URL').':'.env(key: 'PAPERTRAIL_PORT'),
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env(key: 'LOG_LEVEL', default: 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env(key: 'LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env(key: 'LOG_LEVEL', default: 'debug'),
            'facility' => env(key: 'LOG_SYSLOG_FACILITY', default: LOG_USER),
            'replace_placeholders' => true,
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env(key: 'LOG_LEVEL', default: 'debug'),
            'replace_placeholders' => true,
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path(path: 'logs/laravel.log'),
        ],

    ],

];

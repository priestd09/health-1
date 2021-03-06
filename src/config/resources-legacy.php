<?php

return [

    'resources' => [
        'health' => [
            'abbreviation' => 'hlth',
            'columnSize' => '12',
            'checker' => PragmaRX\Health\Checkers\HealthChecker::class,
            'is_global' => true,
            'notify' => false,
            'error_message' => 'At least one resource failed the health check.',
        ],

        'database' => [
            'abbreviation' => 'db',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\DatabaseChecker::class,
            'notify' => true,
            'models' => [
                App\User::class,
            ],
        ],

        'cache' => [
            'abbreviation' => 'csh',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\CacheChecker::class,
            'notify' => true,
            'error_message' => 'Cache is not returning cached values.',
            'key' => 'health-cache-test',
            'minutes' => 1,
        ],

        'framework' => [
            'abbreviation' => 'frmwrk',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\FrameworkChecker::class,
            'notify' => true,
        ],

        'https' => [
            'abbreviation' => 'https',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\HttpsChecker::class,
            'notify' => true,
            'url' => config('app.url'),
        ],

        'http' => [
            'abbreviation' => 'http',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\HttpChecker::class,
            'notify' => true,
            'url' => config('app.url'),
        ],

        'laravelServices' => [
            'abbreviation' => 'lvs',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\HttpsChecker::class,
            'notify' => true,
            'connection_timeout' => 2,
            'roundtrip_timeout' => 1,
            'timeout_message' => '[TIMEOUT] A request to %s took %s seconds. Timeout is set to %s.',
            'url' => [
                'https://forge.laravel.com',
                'https://envoyer.io',
            ],
        ],

        'mail' => [
            'abbreviation' => 'ml',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\MailChecker::class,
            'notify' => true,
            'view' => 'pragmarx/health::default.email',
            'config' => [
                'driver' => 'log',

                'host' => env('MAIL_HOST', 'smtp.mailgun.org'),

                'port' => env('MAIL_PORT', 587),

                'from' => [
                    'address' => 'health@example.com',
                    'name' => 'Health Checker',
                ],

                'encryption' => env('MAIL_ENCRYPTION', 'tls'),

                'username' => env('MAIL_USERNAME'),

                'password' => env('MAIL_PASSWORD'),

                'sendmail' => '/usr/sbin/sendmail -bs',
            ],
            'to' => 'you-know-who@sink.sendgrid.net',
            'subject' => 'Health Test mail',
        ],

        'filesystem' => [
            'abbreviation' => 'flstm',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\FilesystemChecker::class,
            'notify' => true,
            'error-message' => 'Unable to create temp file: %s.',
        ],

        'cloud_storage' => [
            'abbreviation' => 'cld',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\CloudStorageChecker::class,
            'notify' => true,
            'driver' => 'local',
            'file' => 'testfile-'.Illuminate\Support\Str::random(32).'.txt',
            'contents' => Illuminate\Support\Str::random(1024),
            'error_message' => 'Cloud storage is not retrieving files correctly.',
        ],

        'queue' => [
            'abbreviation' => 'queue',
            'name' => 'health-queue',
            'cache_instance' => 'cache',
            'test_job' => PragmaRX\Health\Support\Jobs\TestJob::class,
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\QueueChecker::class,
            'notify' => true,
            'connection' => '',
            'error_message' => 'Queue system is not working properly.',
        ],

        'redis' => [
            'abbreviation' => 'rds',
            'key' => 'health:redis:key',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\RedisChecker::class,
            'notify' => true,
            'connection' => '',
            'error_message' => 'Got a wrong value back from Redis.',
        ],

        'serverUptime' => [
            'abbreviation' => 'uptm',
            'columnSize' => '6',
            'regex' => $uptimeRegex = '~(?<time_hour>\d{1,2}):(?<time_minute>\d{2})(?::(?<time_second>\d{2}))?\s+up\s+(?:(?<up_days>\d+)\s+days?,\s+)?\b(?:(?<up_hours>\d+):)?(?<up_minutes>\d+)(?:\s+(?:minute|minutes|min)?)?,\s+(?<users>\d+).+?(?<load_1>\d+.\d+),?\s+(?<load_5>\d+.\d+),?\s+(?<load_15>\d+.\d+)~',
            'checker' => PragmaRX\Health\Checkers\ServerUptimeChecker::class,
            'command' => 'uptime 2>&1',
            'save_to' => $path.'/uptime.json',
            'notify' => true,
            'action_message' => 'Your server was rebooted (Uptime Checker)',
            'error_message' => 'Looks like your server was recently rebooted, current uptime is now "%s" and it was "%s" before restart.',
        ],

        'serverLoad' => [
            'abbreviation' => 'load',
            'columnSize' => '6',
            'regex' => $uptimeRegex,
            'checker' => PragmaRX\Health\Checkers\ServerLoadChecker::class,
            'command' => 'uptime 2>&1',
            'max_load' => [
                'load_1' => 2,
                'load_5' => 1.5,
                'load_15' => 1,
            ],
            'notify' => true,
            'action_message' => 'Too much load! (Server Load Checker)',
            'error_message' => 'Your server might be overloaded, current server load values are "%s, %s and %s", which are above the threshold values: "%s, %s and %s".',
        ],

        'broadcasting' => [
            'abbreviation' => 'brdc',
            'columnSize' => '6',
            'channel' => 'pragmarx-health-broadcasting-channel',
            'checker' => PragmaRX\Health\Checkers\BroadcastingChecker::class,
            'route_name' => $routeName = 'pragmarx.health.broadcasting.callback',
            'secret' => str_random(),
            'timeout' => 30,
            'routes' => [
                $routeName => [
                    'uri' => '/health/broadcasting/callback/{secret}',
                    'controller' => PragmaRX\Health\Http\Controllers\Broadcasting::class,
                    'action' => 'callback',
                ],
            ],
            'save_to' => $path.'/broadcasting.json',
            'notify' => true,
            'error_message' => 'The broadcasting service did not respond in time, it may be in trouble.',
        ],

        'rebootRequired' => [
            'abbreviation' => 'rbtrqrd',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\DirectoryAndFilePresenceChecker::class,
            'files' => [
                '/var/run/reboot-required' => PragmaRX\Health\Checkers\DirectoryAndFilePresenceChecker::FILE_DOES_NOT_EXISTS,
            ],
            'notify' => true,
            'error_message' => 'A reboot is required in this server (Uptime Checker)',
        ],

        'docu_sign' => [
            'abbreviation' => 'dcsgn',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\DocusignChecker::class,
            'email' => env('DOCUSIGN_USERNAME'),
            'password' => env('DOCUSIGN_PASSWORD'),
            'integrator_key' => env('DOCUSIGN_INTEGRATOR_KEY'),
            'debug' => env('DOCUSIGN_DEBUG'),
            'debug_file' => storage_path('logs/docusign.log'),
            'notify' => true,
            'api_host' => env('DOCUSIGN_HOST'),
            'error_message' => 'A reboot is required in this server (Uptime Checker)',
        ],

        'supervisor' => [
            'abbreviation' => 'sprvsr',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\ProcessChecker::class,
            'command' => 'ps aux | grep python | grep supervisord',
            'method' => PragmaRX\Health\Checkers\ProcessChecker::METHOD_PROCESS_COUNT,
            'process_name' => 'supervisor',
            'pid_file' => '',
            'instances' => [
                'minimum' => [
                    'count' => 1,
                    'message' => 'Process "%s" has not enough instances running: it has %s, when should have at least %s',
                ],
                'maximum' => [
                    'count' => 3,
                    'message' => 'Process "%s" exceeded the maximum number of running instances: it has %s, when should have at most %s',
                ],
            ],
            'notify' => true,
            'pid_file_missing_error_message' => 'Process ID file is missing: %s.',
            'pid_file_missing_not_locked' => 'Process ID file is not being used by any process: %s.',
            'error_message' => 'Supervisor is not running',
        ],

        'php' => [
            'abbreviation' => 'php',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\ProcessChecker::class,
            'command' => 'pgrep %s',
            'method' => PragmaRX\Health\Checkers\ProcessChecker::METHOD_PROCESS_COUNT,
            'process_name' => 'php-fpm',
            'pid_file' => '/tmp/php7.1-fpm.pid',
            'instances' => [
                'minimum' => [
                    'count' => 2,
                    'message' => 'Process "%s" has not enough instances running: it has %s, when should have at least %s',
                ],
                'maximum' => [
                    'count' => 20,
                    'message' => 'Process "%s" exceeded the maximum number of running instances: it has %s, when should have at most %s',
                ],
            ],
            'notify' => true,
            'pid_file_missing_error_message' => 'Process ID file is missing: %s.',
            'pid_file_missing_not_locked' => 'Process ID file is not being used by any process: %s.',
            'error_message' => 'Supervisor is not running',
        ],

        'my_sql' => [
            'abbreviation' => 'msql',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\ProcessChecker::class,
            'command' => 'pgrep %s',
            'method' => PragmaRX\Health\Checkers\ProcessChecker::METHOD_PROCESS_COUNT,
            'process_name' => 'mysqld',
            'pid_file' => '',
            'instances' => [
                'minimum' => [
                    'count' => 1,
                    'message' => 'Process "%s" has not enough instances running: it has %s, when should have at least %s',
                ],
                'maximum' => [
                    'count' => 20,
                    'message' => 'Process "%s" exceeded the maximum number of running instances: it has %s, when should have at most %s',
                ],
            ],
            'notify' => true,
            'pid_file_missing_error_message' => 'Process ID file is missing: %s.',
            'pid_file_missing_not_locked' => 'Process ID file is not being used by any process: %s.',
            'error_message' => 'Supervisor is not running',
        ],

        'redis_server' => [
            'abbreviation' => 'rdssrvr',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\ProcessChecker::class,
            'command' => 'pgrep %s',
            'method' => PragmaRX\Health\Checkers\ProcessChecker::METHOD_PROCESS_COUNT,
            'process_name' => 'redis-server',
            'pid_file' => '',
            'instances' => [
                'minimum' => [
                    'count' => 1,
                    'message' => 'Process "%s" has not enough instances running: it has %s, when should have at least %s',
                ],
                'maximum' => [
                    'count' => 20,
                    'message' => 'Process "%s" exceeded the maximum number of running instances: it has %s, when should have at most %s',
                ],
            ],
            'notify' => true,
            'pid_file_missing_error_message' => 'Process ID file is missing: %s.',
            'pid_file_missing_not_locked' => 'Process ID file is not being used by any process: %s.',
            'error_message' => 'Supervisor is not running',
        ],

        'queue_workers' => [
            'abbreviation' => 'qwrkrs',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\ProcessChecker::class,
            'command' => 'ps aux | grep php | grep queue:work',
            'method' => PragmaRX\Health\Checkers\ProcessChecker::METHOD_PROCESS_COUNT,
            'process_name' => 'php',
            'pid_file' => '',
            'instances' => [
                'minimum' => [
                    'count' => 1,
                    'message' => 'Process "%s" has not enough instances running: it has %s, when should have at least %s',
                ],
                'maximum' => [
                    'count' => 3,
                    'message' => 'Process "%s" exceeded the maximum number of running instances: it has %s, when should have at most %s',
                ],
            ],
            'notify' => true,
            'pid_file_missing_error_message' => 'Process ID file is missing: %s.',
            'pid_file_missing_not_locked' => 'Process ID file is not being used by any process: %s.',
            'error_message' => 'Supervisor is not running',
        ],

        'newrelic_deamon' => [
            'abbreviation' => 'nwrlcdmn',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\ProcessChecker::class,
            'command' => 'pgrep %s',
            'method' => PragmaRX\Health\Checkers\ProcessChecker::METHOD_PROCESS_COUNT,
            'process_name' => 'newrelic-daemon',
            'pid_file' => '',
            'instances' => [
                'minimum' => [
                    'count' => 1,
                    'message' => 'Process "%s" has not enough instances running: it has %s, when should have at least %s',
                ],
                'maximum' => [
                    'count' => 1,
                    'message' => 'Process "%s" exceeded the maximum number of running instances: it has %s, when should have at most %s',
                ],
            ],
            'notify' => true,
            'pid_file_missing_error_message' => 'Process ID file is missing: %s.',
            'pid_file_missing_not_locked' => 'Process ID file is not being used by any process: %s.',
            'error_message' => 'Supervisor is not running',
        ],

        'sshd' => [
            'abbreviation' => 'sshd',
            'columnSize' => '6',
            'checker' => PragmaRX\Health\Checkers\ProcessChecker::class,
            'command' => 'pgrep %s',
            'method' => PragmaRX\Health\Checkers\ProcessChecker::METHOD_PROCESS_COUNT,
            'process_name' => 'sshd',
            'pid_file' => '',
            'instances' => [
                'minimum' => [
                    'count' => 1,
                    'message' => 'Process "%s" has not enough instances running: it has %s, when should have at least %s',
                ],
                'maximum' => [
                    'count' => 15,
                    'message' => 'Process "%s" exceeded the maximum number of running instances: it has %s, when should have at most %s',
                ],
            ],
            'notify' => true,
            'pid_file_missing_error_message' => 'Process ID file is missing: %s.',
            'pid_file_missing_not_locked' => 'Process ID file is not being used by any process: %s.',
            'error_message' => 'Supervisor is not running',
        ],

    ],

];

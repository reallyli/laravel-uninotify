<?php

return [
    // Exclude environments that do not receive notifications local,devel,production
    'execlude_notify_environment' => [
        'local',
    ],
    // Whether to enable catch exception true or false
    'enabled_throw_exception' => true,
    // Configure channel name and address
    'channel_url' => [
        'group' => '',
        'deploy' => ''
    ],
    // Configure the appropriate log level ['error', 'info', 'debug']
    'logger_level' => 'error'
];
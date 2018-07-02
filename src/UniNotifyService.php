<?php

namespace Reallyli\Uninotify;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\App;
use Ixudra\Curl\Facades\Curl;

/**
 * Class UniquewayNotificationService
 * @package Reallyli\UniquewayNotification
 */
class UniNotifyService
{
    /**
     * @var string
     */
    protected $logPrefix = '[Packages.Reallyli.UniNotify]';

    /**
     * @var array
     */
    protected $config;

    /**
     * Method description:__construct
     *
     * @author reallyli <zlisreallyli@outlook.com>
     * @since 18/6/29
     * @param Repository $config
     * @return mixed
     * 返回值类型：string，array，object，mixed（多种，不确定的），void（无返回值）
     */
    public function __construct(Repository $config)
    {
        $this->config = $config->get('uninotify');
    }

    /**
     * Method description:send
     *
     * @author reallyli <zlisreallyli@outlook.com>
     * @since 18/6/29
     * @param string $message
     * @param string $type
     * @return mixed
     * 返回值类型：string，array，object，mixed（多种，不确定的），void（无返回值）
     */
    public function send(string $message, string $type)
    {
        throw_unless(
            $this->config,
            '\Exception',
            $this->logPrefix . 'Please publish the configuration file, php artisan vendor:publish'
        );

        $logLevel = in_array($this->config['logger_level'], ['error', 'info', 'debug']) ?
            $this->config['logger_level'] :
            'error';

        if (is_array($this->config['execlude_notify_environment'])) {
            foreach ($this->config['execlude_notify_environment'] as $env) {
                if ($env === App::environment()) {
                    logger()->info($this->logPrefix . 'Current environment notify is excluded');
                    return true;
                }
            }
        }

        throw_unless(
            array_key_exists($type, $this->config['channel_url']) &&
            ! $this->config['enabled_throw_exception'],
            '\Exception',
            $this->logPrefix . 'Channel url not found'
        );

        throw_unless(
            $this->config['channel_url'][$type],
            '\Exception',
            $this->logPrefix . 'Channel url not set'
        );

        try {
            Curl::to($this->config['channel_url'][$type])
                ->withData(['text' => $message])
                ->asJson()
                ->post();
        } catch (\Exception $exception) {
            logger()->{$logLevel}($exception->getMessage());
            throw_unless(
                $this->config['enabled_throw_exception'],
                '\Exception',
                $this->logPrefix . $exception->getMessage()
            );
        }

        return true;
    }

}


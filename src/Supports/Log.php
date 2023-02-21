<?php

namespace Lijinhua\HyperfJpush\Supports;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;
use Psr\Log\LoggerInterface;

class Log
{
    /**
     * 日志通道
     *
     * @param  string  $name
     * @return \Psr\Log\LoggerInterface
     */
    public static function channel(string $name = 'app'): LoggerInterface
    {
        $group = ApplicationContext::getContainer()->get(ConfigInterface::class)->get('jpush.log.group');
        return ApplicationContext::getContainer()->get(LoggerFactory::class)->get($name, $group);
    }

    /**
     * 接口请求日志
     *
     * @return \Psr\Log\LoggerInterface
     */
    public static function request(): LoggerInterface
    {
        return self::channel('request');
    }

    /**
     * 接口返回日志
     *
     * @return \Psr\Log\LoggerInterface
     */
    public static function response(): LoggerInterface
    {
        return self::channel('response');
    }

}
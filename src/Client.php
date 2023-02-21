<?php

namespace Lijinhua\HyperfJpush;

use Lijinhua\HyperfJpush\Payloads\DevicePayload;
use Lijinhua\HyperfJpush\Payloads\PushPayload;
use Lijinhua\HyperfJpush\Payloads\ReportPayload;
use Lijinhua\HyperfJpush\Payloads\SchedulePayload;

class Client
{

    /**
     * @var string
     */
    private string $appKey;

    /**
     * @var string
     */
    private string $masterSecret;

    /**
     * @var string|null
     */
    private ?string $zone;

    private array $zones = [
        'DEFAULT' => [
            'push'     => 'https://api.jpush.cn/v3/',
            'report'   => 'https://report.jpush.cn/v3/',
            'device'   => 'https://device.jpush.cn/v3/devices/',
            'alias'    => 'https://device.jpush.cn/v3/aliases/',
            'tag'      => 'https://device.jpush.cn/v3/tags/',
            'schedule' => 'https://api.jpush.cn/v3/schedules',
        ],
        'BJ'      => [
            'push'      => 'https://bjapi.push.jiguang.cn/v3/',
            'report'    => 'https://bjapi.push.jiguang.cn/v3/report/',
            'device'    => 'https://bjapi.push.jiguang.cn/v3/device/',
            'alias'     => 'https://bjapi.push.jiguang.cn/v3/device/aliases/',
            'tag'       => 'https://bjapi.push.jiguang.cn/v3/device/tags/',
            'schedules' => 'https://bjapi.push.jiguang.cn/v3/push/schedules',
        ],
    ];

    /**
     * @param  string  $appKey
     * @param  string  $masterSecret
     * @param  string|null  $zone
     */
    public function __construct(string $appKey, string $masterSecret, ?string $zone = null)
    {
        $this->appKey       = $appKey;
        $this->masterSecret = $masterSecret;

        if (!is_null($zone) && in_array(strtoupper($zone), array_keys($this->zones))) {
            $this->zone = strtoupper($zone);
        } else {
            $this->zone = null;
        }
    }

    /**
     * @return \Lijinhua\HyperfJpush\Payloads\PushPayload
     */
    public function push(): PushPayload
    {
        return new PushPayload($this);
    }

    /**
     * @return \Lijinhua\HyperfJpush\Payloads\ReportPayload
     */
    public function report(): ReportPayload
    {
        return new ReportPayload($this);
    }

    /**
     * @return \Lijinhua\HyperfJpush\Payloads\DevicePayload
     */
    public function device(): DevicePayload
    {
        return new DevicePayload($this);
    }

    /**
     * @return \Lijinhua\HyperfJpush\Payloads\SchedulePayload
     */
    public function schedule(): SchedulePayload
    {
        return new SchedulePayload($this);
    }

    /**
     * @return string
     */
    public function getAuthStr(): string
    {
        return $this->appKey . ":" . $this->masterSecret;
    }

    /**
     * @return array
     */
    public function getAuthArray(): array
    {
        return [$this->appKey, $this->masterSecret];
    }

    /**
     * @return bool
     */
    public function isGroup(): bool
    {
        $str = substr($this->appKey, 0, 6);
        return $str === 'group-';
    }

    /**
     * @param  string  $key
     * @return mixed|string
     */
    public function makeURL(string $key)
    {
        if (is_null($this->zone)) {
            return $this->zones['DEFAULT'][$key];
        } else {
            return $this->zones[$this->zone][$key];
        }
    }
}

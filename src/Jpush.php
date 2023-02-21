<?php

namespace Lijinhua\HyperfJpush;

use Hyperf\Contract\ConfigInterface;

class Jpush
{
    /**
     * @var \Hyperf\Contract\ConfigInterface
     */
    protected ConfigInterface $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return \Lijinhua\HyperfJpush\Client
     */
    public function client(): Client
    {
        $config = $this->config->get('jpush');
        return new Client($config['app_key'], $config['master_secret']);
    }
}
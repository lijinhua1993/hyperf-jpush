<?php

namespace Lijinhua\HyperfJpush\Payloads;

use Hyperf\Utils\ApplicationContext;
use Lijinhua\HyperfJpush\Client;
use Lijinhua\HyperfJpush\Supports\Http;

abstract class AbstractPayload
{

    /**
     * @var \Lijinhua\HyperfJpush\Client
     */
    protected Client $client;

    /**
     * @var \Lijinhua\HyperfJpush\Supports\Http
     */
    protected Http $http;

    /**
     * @param  \Lijinhua\HyperfJpush\Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->http   = ApplicationContext::getContainer()->get(Http::class);

        $this->init();
    }

    protected function init(): void
    {
    }
}

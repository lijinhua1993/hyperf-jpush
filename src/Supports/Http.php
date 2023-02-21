<?php

namespace Lijinhua\HyperfJpush\Supports;

use GuzzleHttp\Client;
use Hyperf\Guzzle\ClientFactory;
use Lijinhua\HyperfJpush\Constants\ConfigConstant;
use Lijinhua\HyperfJpush\Exceptions\APIRequestException;
use Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable;
use Psr\Http\Message\ResponseInterface;

class Http
{

    /**
     * @var \Hyperf\Guzzle\ClientFactory
     */
    private ClientFactory $clientFactory;

    /**
     * @param  \Hyperf\Guzzle\ClientFactory  $clientFactory
     */
    public function __construct(ClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    /**
     * @param  array  $options
     * @return \GuzzleHttp\Client
     */
    public function client(array $options = []): Client
    {
        return $this->clientFactory->create($options);
    }

    /**
     * @param $client
     * @param $url
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function get($client, $url): array
    {
        $response = $this->sendRequest($client, $url, 'GET');
        return $this->processResp($response);
    }

    /**
     * @param $client
     * @param $url
     * @param $body
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function post($client, $url, $body): array
    {
        $response = $this->sendRequest($client, $url, 'POST', $body);
        return $this->processResp($response);
    }

    /**
     * @param $client
     * @param $url
     * @param $body
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function put($client, $url, $body): array
    {
        $response = $this->sendRequest($client, $url, 'PUT', $body);
        return $this->processResp($response);
    }

    /**
     * @param $client
     * @param $url
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function delete($client, $url): array
    {
        $response = $this->sendRequest($client, $url, 'DELETE');
        return $this->processResp($response);
    }

    /**
     * @param $client
     * @param $url
     * @param $method
     * @param  array|null  $body
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function sendRequest($client, $url, $method, ?array $body = null): ResponseInterface
    {
        Log::request()->debug(sprintf('%s %s:', $method, $url), (array) $body);

        $options = [
            'auth'            => $client->getAuthArray(),
            'headers'         => [
                'User-Agent'   => ConfigConstant::USER_AGENT,
                'Connection'   => 'Keep-Alive',
                'Content-Type' => 'application/json',
            ],
            'version'         => 3,
            'connect_timeout' => ConfigConstant::CONNECT_TIMEOUT,
            'timeout'         => ConfigConstant::READ_TIMEOUT,
        ];
        if (!is_null($body)) {
            $options['json'] = $body;
        }

        return $this->client()->request($method, $url, $options);
    }

    /**
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function processResp(ResponseInterface $response): array
    {
        $code     = $response->getStatusCode();
        $contents = $response->getBody()->getContents();
        $headers  = $response->getHeaders();
        $result   = [
            'http_code' => $code,
            'headers'   => $headers,
        ];
        if ($code === 200) {
            $result['body'] = json_decode($contents, true);
            return $result;
        } elseif (is_null($contents)) {
            $result['body'] = $contents;
            throw new ServiceNotAvailable($result);
        } else {
            $result['body'] = $contents;
            throw new APIRequestException($result);
        }
    }

}
<?php

namespace Lijinhua\HyperfJpush\Exceptions;

class ServiceNotAvailable extends JPushException
{

    private $http_code;
    private $headers;

    public function __construct($response)
    {
        $this->http_code = $response['http_code'];
        $this->headers   = $response['headers'];
        $this->message   = $response['body'];
    }

    public function __toString()
    {
        return "\n" . __CLASS__ . " -- [{$this->http_code}]: {$this->message} \n";
    }

    public function getHttpCode()
    {
        return $this->http_code;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}

<?php

namespace Lijinhua\HyperfJpush\Exceptions;

class APIConnectionException extends JPushException
{

    public function __toString()
    {
        return "\n" . __CLASS__ . " -- {$this->message} \n";
    }
}

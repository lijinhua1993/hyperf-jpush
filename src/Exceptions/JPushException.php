<?php

namespace Lijinhua\HyperfJpush\Exceptions;

class JPushException extends \Exception
{

    public function __construct($message)
    {
        parent::__construct($message);
    }
}

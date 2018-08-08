<?php

namespace src\services\providers;

use GuzzleHttp\Client;
use src\exceptions\ApiException;

abstract class ApiLotoConnector
{
    protected $client;

    public function __construct()
    {
        $this->client= new Client();
    }

    abstract protected function setDraw($response);

    protected function throwException($message, $code = 400)
    {
        throw new ApiException($message, $code);
    }

}
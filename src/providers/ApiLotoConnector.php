<?php
/**
 *
 * Clase que brinda la conexion para cualquier API de loterias.
 *
 */
namespace src\providers;

use GuzzleHttp\Client;
use src\exceptions\ApiException;

abstract class ApiLotoConnector
{
    protected $client;

    public function __construct()
    {
        $this->client= new Client();
    }
    /**
     *
     * Metodo obligatorio que deben tener todas las API de loterias que normaliza la respuesta de la API.
     *
     */
    abstract protected function setDraw($response);

    protected function throwException($message, $code = 400)
    {
        throw new ApiException($message, $code);
    }

}
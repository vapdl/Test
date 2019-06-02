<?php
/**
 *
 * Clase que muestra excepciones generadas por la conexion con Redis
 *
 */
namespace src\exceptions;

use Exception;

class RedisException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
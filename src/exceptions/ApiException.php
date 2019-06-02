<?php
/**
 *
 * Clase que muestra excepciones generadas por la conexion con alguna API
 *
 */
namespace src\exceptions;

use Exception;

class ApiException extends Exception
{
    public function __construct($message, $code = 400)
    {
        parent::__construct($message, $code);
    }
}
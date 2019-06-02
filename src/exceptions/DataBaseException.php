<?php
/**
 *
 * Clase que muestra excepciones generadas por la conexion con alguna Base de Datos
 *
 */
namespace src\exceptions;

use Exception;

class DataBaseException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
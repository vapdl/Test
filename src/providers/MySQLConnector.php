<?php
/**
 *
 * Clase que brinda la conexion para cualquier Base de datos MySQL.
 *
 */
namespace src\providers;

use src\exceptions\DataBaseException;


define('DBADDRESS', '127.0.0.1');
define('DBUSER', 'root');
define('DBPASSWORD', 'mypassword');
define('DBSCHEMA', 'euromillions');

trait MySQLConnector
{
    protected $mysqli;


    private function openConnection()
    {
        $this->mysqli = new \mysqli(DBADDRESS, DBUSER, DBPASSWORD, DBSCHEMA);
        if (mysqli_connect_errno()) {
            $this->throwException(mysqli_connect_error());
        }

    }

    private function closeConnection()
    {
        $this->mysqli->close();
    }

    protected function throwException($message)
    {
        throw new DataBaseException($message);
    }

}
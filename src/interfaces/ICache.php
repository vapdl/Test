<?php
/**
 *
 * Intefaz para los modelos que tendran Caching de sus registros.
 *
 */
namespace src\interfaces;

interface ICache
{
    public function put($key, $json);
    public function get($key);
}
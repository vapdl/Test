<?php
/**
 *
 * Clase que brinda la conexion para cualquier Base de Datos REDIS.
 *
 */
namespace src\providers;

use Predis\Client;
use src\exceptions\RedisException;

trait RedisConnector
{
    private $redis;

    public function __construct()
    {
        try
        {
            $this->redis = new Client();
        }
        catch(\Exception $e)
        {
            throw new RedisException($e->getMessage());
        }

    }

    public function put($key, $json)
    {
        try
        {
        $this->redis->set($key, $json);
        }
        catch(\Exception $e)
        {
            throw new RedisException($e->getMessage());
        }
    }

    public function get($key)
    {
        try
        {
            $aux=$this->redis->get($key);
        }
        catch(\Exception $e)
        {
            throw new RedisException($e->getMessage());
        }
        return (array)json_decode($aux);
    }
}
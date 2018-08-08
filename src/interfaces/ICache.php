<?php
namespace src\interfaces;

interface ICache
{
    public function put($json);
    public function get($key);
}
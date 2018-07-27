<?php

interface ICache
{
    public function put($json);
    public function get($key);
}
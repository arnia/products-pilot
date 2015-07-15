<?php

class Singleton extends SessionHandler
{
    protected static $instance = null;

    protected function __construct()
    {

    }

    protected function __clone()
    {

    }

    public static function getInstance($key, $name = 'MY_SESSION', $cookie = [])
    {
        if (!isset(static::$instance)) {
            static::$instance = new static($key,$name,$cookie);
        }
        return static::$instance;
    }
}
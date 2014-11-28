<?php

namespace App\Core;

use App\Services;

class Container {

    protected static $registry = array();

    public static function register($name, $resolve)
    {
        static::$registry[$name] = $resolve;
    }
 
    public static function get($name)
    {
        if (static::registered($name))
        {
            $name = static::$registry[$name];
            return $name();
        }
 
        throw new \Exception($name.' is unregistered');
    }

    public static function registered($name)
    {
        return array_key_exists($name, static::$registry);
    }

    public static function init()
    {
        Services::registerServices();
    }
}
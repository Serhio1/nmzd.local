<?php

namespace App\Core;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Dispatcher
{

    protected static $_instance;

    private function __construct(){}

    private function __clone(){}

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            static::$_instance = new EventDispatcher();
        }

        return self::$_instance;
    }

}
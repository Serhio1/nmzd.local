<?php

namespace App\Core;

interface IModule
{

    public function install();

    public function init();

    public function boot();

    public function getRoutes();

    public function uninstall();

}
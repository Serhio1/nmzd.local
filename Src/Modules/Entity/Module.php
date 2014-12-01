<?php

/**
 * Provides abstract lay for entities.
 */

namespace Src\Modules\Admin;

use App\Core\BaseModule;
use App\Core\Container;
use Src\Modules\Admin\Models\AdminModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Router;

class Module extends BaseModule
{
    /*
     * Fires on module enabling.
     */
    public function install()
    {

    }
    /**
     * Defines module services in service container. Fires on every request.
     */
    public function init()
    {

    }

    /**
     * Main method. Fires on every request.
     *
     * @throws \Exception
     */
    public function boot()
    {

    }

    /**
     * Defines array of routes for this module.
     *
     * To define route you need to add array element to result array.
     * Element must contain this structure:
     * id => array(
     *     'uri' => '/address/to/needle',
     *     'settings' => array(
     *         '_controller' => Closure
     *     ),
     * ),
     *
     * Read more in HttpKernel documentation
     * @see Symfony\Component\Routing\RouteCollection
     * @see Symfony\Component\Routing\Route
     *
     * @return array
     */
    public function getRoutes()
    {
        return array();
    }
}

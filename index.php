<?php

use App\Core\BaseRouter;
use App\Core\Kernel;
use App\Core\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpFoundation\Response;
use App\Routes;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;


if (!isset($_SESSION)) {
    session_start();
}

$autoloader = require_once __DIR__ . '/vendor/autoload.php';

$request = Request::createFromGlobals();
$kernel = Kernel::createFromRequest($request, $autoloader);
$kernel->handle($request)->send();



/**
 * Prints variable.
 *
 * Only for testing.
 *
 * @param $var
 */
function dump($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre><br>';
}







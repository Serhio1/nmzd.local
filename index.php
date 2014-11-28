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


/*$response = $kernel->handle($request)
            ->prepare($request)->send();*/

/*
$routes = Routes::getAll();

$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher));

$resolver = new ControllerResolver();

$kernel = new HttpKernel($dispatcher, $resolver);



$kernel->handle($request)->send();

$response = $kernel->handle($request);

//dump($response);

*/
/*require_once 'autoloader.php';
require_once 'vendor/autoload.php';*/

//$router = new Router;

/*Container::init();
Container::get('router')->init();*/

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







<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use App\Routes;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use App\Core\Container;
use App\Parameters;

use Src\Modules\Devel\Router;



class Kernel implements HttpKernelInterface
{
    /**
     * Whether the kernel has been booted.
     *
     * @var bool
     */
    protected $booted = FALSE;

    /**
     * Constructs a Kernel object.
     *
     * @param $class_loader
     *   The class loader. Normally \Composer\Autoload\ClassLoader, as included by
     *   the front controller, but may also be decorated; e.g.,
     *   \Symfony\Component\ClassLoader\ApcClassLoader.
     */
    public function __construct($class_loader)
    {
        $this->classLoader = $class_loader;
    }

    /**
     * Create a Kernel object from a request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The request.
     * @param $class_loader
     *   The class loader. Normally Composer's ClassLoader, as included by the
     *   front controller, but may also be decorated; e.g.,
     *   \Symfony\Component\ClassLoader\ApcClassLoader.
     * @param string $environment
     *   String indicating the environment, e.g. 'prod' or 'dev'.
     * @param bool $allow_dumping
     *   (optional) FALSE to stop the container from being written to or read
     *   from disk. Defaults to TRUE.
     *
     * @return static
     */
    public static function createFromRequest(Request $request, $class_loader)
    {
        static::initContainer();

        $routes = Routes::getAll();

        $context = new RequestContext();
        $context->fromRequest($request);

        $matcher = new UrlMatcher($routes, $context);

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new RouterListener($matcher));

        $resolver = new ControllerResolver();

        $kernel = new HttpKernel($dispatcher, $resolver);

        return $kernel;
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = TRUE)
    {
        return $this->getHttpKernel()->handle($request, $type, $catch);
    }

    public function boot()
    {
        if ($this->booted) {
            return $this;
        }

        $this->booted = TRUE;


        return $this;
    }

    /**
     * Gets a http kernel from the container
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    protected function getHttpKernel()
    {
        return $this->container->get('http_kernel');
    }

    /**
     * Initializes the service container.
     *
     *   Force a container rebuild.
     */
    protected static function initContainer() {
        Container::init();
    }

}
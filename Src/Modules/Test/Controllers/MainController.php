<?php

/**
 * Main controller for Test module
 */

namespace Src\Modules\Test\Controllers;

use App\Core\Container;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Controller;

class MainController extends Controller
{

    public function indexAction($request)
    {
        return new Response('This is Test index action.');
    }
    
}
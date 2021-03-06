<?php

use App\Core\Kernel;
use Symfony\Component\HttpFoundation\Request;

ini_set('session.cache_limiter','public');
session_cache_limiter(false);
if (!isset($_SESSION)) {
    session_start();
}
//unset($_SESSION['nmkd_form']);

$autoloader = require_once __DIR__ . '/vendor/autoload.php';

$request = Request::createFromGlobals();
$kernel = Kernel::createFromRequest($request, $autoloader);
$kernel->handle($request)->send();
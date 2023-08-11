<?php

include_once('init.php');
include_once('vendor/autoload.php');

const BASE_URL = '/';
const DB_HOST = 'localhost';
const DB_NAME = 'oop';
const DB_USER = 'root';
const DB_PASS = '';

use System\Router;
use System\ModulesDispatcher;
use Modules\Articles\Controllers\Index as ArticleC;
use Modules\Articles\Module as Articles;
use System\Exceptions\Exc404;

try {
$modules = new ModulesDispatcher;
$modules->add(new Articles());
$router = new Router(BASE_URL);

$modules->registerRoutes($router);

$uri = $_SERVER['REQUEST_URI'];
$activeRoute = $router->resolvePath($uri);

$c = $activeRoute['controller'];
$m = $activeRoute['method'];

$c->$m();
$html = $c->render();
echo $html;

} 
catch (Exc404 $e) {
    echo '404 error ' . $e->getMessage();
}
catch (Throwable $e) {
    echo 'nice fatal error must be here ' . $e->getMessage();
}
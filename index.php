<?php

include_once('init.php');
const BASE_URL = '/';

use System\Router;
use Articles\Controller as ArticleC;

try {
$router = new Router(BASE_URL);

$router->addRoute('', ArticleC::class);
$router->addRoute('article/1', ArticleC::class, 'item');
$router->addRoute('article/2', ArticleC::class, 'item'); // e t.c post/99, post/100 lol :))

$uri = $_SERVER['REQUEST_URI'];
$activeRoute = $router->resolvePath($uri);

$c = $activeRoute['controller'];
$m = $activeRoute['method'];

$c->$m();
$html = $c->render();
echo $html;
} catch (Throwable $e) {
    echo 'nice fatal error must be here';
}
?>

<hr>
Menu
<a href="<?=BASE_URL?>">Home</a>
<a href="<?=BASE_URL?>article/1">Art 1</a>
<a href="<?=BASE_URL?>article/2">Art 2</a>
<?php

namespace Modules\Articles;
use System\Contracts\IModule;
use System\Contracts\IRouter;
use Modules\Articles\Controllers\Index as ArticleC;

class Module implements IModule
{
    public function registerRoutes(IRouter $router) : void
    {
        $i = '[1-9]+\d*';
        $map = [1 => 'id'];
        $router->addRoute('/^$/', ArticleC::class);
        $router->addRoute("/^article\/($i)$/", ArticleC::class, 'item', $map);
        $router->addRoute('/^article\/add$/', ArticleC::class, 'add');
        $router->addRoute("/^article\/delete\/($i)/", ArticleC::class, 'remove', $map);
        $router->addRoute("/^article\/edit\/($i)/", ArticleC::class, 'edit', $map);
    }
}
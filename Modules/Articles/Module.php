<?php

namespace Modules\Articles;
use System\Contracts\IModule;
use System\Contracts\IRouter;
use Modules\Articles\Controllers\Index as ArticleC;

class Module implements IModule
{
    public function registerRoutes(IRouter $router) : void
    {
        $router->addRoute('', ArticleC::class);
        $router->addRoute('article/1', ArticleC::class, 'item');
        $router->addRoute('article/2', ArticleC::class, 'item'); // e t.c post/99, post/100 lol :))
        $router->addRoute('article/add', ArticleC::class, 'add');
        $router->addRoute('article/delete/1', ArticleC::class, 'remove');
        $router->addRoute('article/edit/2', ArticleC::class, 'edit');
    }
}
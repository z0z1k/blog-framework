<?php

namespace Modules\Users;

use System\Contracts\IModule;
use System\Contracts\IRouter;
use Modules\Users\Controllers\Auth as Auth;
use Modules\Users\Controllers\Office as Office;

class Module implements IModule{
	public function registerRoutes(IRouter $router) : void {
		$router->addRoute("/^login$/", Auth::class, 'login');
		$router->addRoute("/^office$/", Office::class);
		$router->addRoute("/^office\/profile$/", Office::class, 'profile');
	}
}
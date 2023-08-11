<?php

namespace System;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Template
{
    public Environment $twig;
    public static $instance = null;

	public static function getInstance() : static
	{
		if (static::$instance === null) {
			static::$instance = new static();
		}
		return static::$instance;
	}

    public function render($pathToTemplate, $vars = []) : string
    {
        return $this->twig->render($pathToTemplate, $vars);
    }

    protected function __construct()
    {
        $loader = new FilesystemLoader('Modules');
        $this->twig = new Environment($loader, [
            'cache' =>'cache/twig',
            'autoreload' => true,
            'autoescape' => false
        ]);
    }
}
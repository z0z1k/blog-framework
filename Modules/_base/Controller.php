<?php

namespace Modules\_base;

use System\Contracts\IController;
use System\Template;
use System\Exceptions\Exc404;

class Controller implements IController{
	protected string $title = '';
	protected string $content = '';
	protected array $env = [];
	protected Template $view;

	public function __construct()
	{
		$this->view = Template::getInstance();
	}

	public function setEnviroment(array $urlParams, array $get, array $post, array $server) : void
	{
		$this->env['params'] = $urlParams;
		$this->env['get'] = $get;
		$this->env['post'] = $post;
		$this->env['server'] = $server;
	}

	public function render() : string
	{
		return $this->view->render('_base/v_main.twig', [
            'title' => $this->title,
            'content' => $this->content,
        ]);
	}

    public function __call(string $name, array $arguments)
    {
        throw new Exc404('not found method' . $name);
    }
}
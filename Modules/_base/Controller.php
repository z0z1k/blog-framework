<?php

namespace Modules\_base;

use System\Contracts\IController;
use System\Template;
use System\Exceptions\Exc404;

class Controller implements IController{
	protected string $title = '';
	protected string $content = '';
	protected array $env;

	public function setEnviroment(array $urlParams) : void
	{
		$this->env = $urlParams;
	}

	public function render() : string
	{
		return Template::render(__DIR__ . '/v_main.php', [
            'title' => $this->title,
            'content' => $this->content,
        ]);
	}

    public function __call(string $name, array $arguments)
    {
        throw new Exc404('not found method' . $name);
    }
}
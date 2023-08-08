<?php
namespace Modules\Articles\Controllers;

use Modules\_base\Controller as BaseC;
use Modules\Articles\Models\Index as ModelIndex;
use System\Contracts\IStorage;

use System\FileStorage;
use System\Template;

use System\Exceptions\ExcValidation;

class Index extends BaseC{
	protected ModelIndex $model;

	public function __construct()
	{
		$this->model = ModelIndex::getInstance();
	}

	public function index()
	{
		$articles = $this->model->all();

		$this->title = 'Home page';
		$this->content = Template::render(__DIR__ . '/../Views/v_all.php', ['articles' => $articles]);
	}

	public function item()
	{
		$this->title = 'Article page';
		$id = (int)$this->env[1];
		$article = $this->model->get($id);

		$this->content = Template::render(__DIR__ . '/../Views/v_item.php', ['article' => $article]);
	}

	public function add()
	{
		$this->title = 'New article';
		try {
			$this->model->add(['title' => '', 'content' => '34']);
		}
		catch (ExcValidation $e) {
			$this->content = $e->getMessage();
		}
	}
}
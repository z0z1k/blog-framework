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
		$id = $this->env['params']['id'];
		$article = $this->model->get($id);

		$this->content = Template::render(__DIR__ . '/../Views/v_item.php', ['article' => $article]);
	}

	public function add()
	{
		$this->title = 'New article';

		if($this->env['server']['REQUEST_METHOD'] === "POST") {
			try {
				$this->model->add(['title' => $this->env['post']['title'], 'content' => $this->env['post']['content']]);
				echo 'Article added';
			}
			catch (ExcValidation $e) {
				$this->content = "Can't add article";
			}
		} else {
			$this->content = Template::render(__DIR__ . '/../Views/v_add.php');
		}
	}

	public function remove()
	{
		var_dump($this->model->remove(1));
	}

	public function edit()
	{
		$this->title = 'Edit article';
		$this->content = '222';
		try {
			$this->model->edit(2, ['title' => '', 'content' => 'new content']);
		}
		catch (ExcValidation $e) {
			$this->content = "can't edit article";
		}
	}
}
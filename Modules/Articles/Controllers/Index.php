<?php
namespace Modules\Articles\Controllers;

use Modules\_base\Controller as BaseC;
use Modules\Articles\Models\Index as ModelIndex;
use System\Contracts\IStorage;
use System\Template;

use System\Exceptions\ExcValidation;
use System\Exceptions\Exc404;

class Index extends BaseC{
	protected ModelIndex $model;

	public function __construct()
	{
		parent::__construct();
		$this->model = ModelIndex::getInstance();
	}

	public function index()
	{
		$articles = $this->model->all();

		$this->title = 'Home page';
		$this->content = $this->view->twig->render('Articles/Views/v_all.twig', ['articles' => $articles]);
	}

	public function item()
	{
		$this->title = 'Article page';
		$id = $this->env['params']['id'];
		$article = $this->model->get($id);
		if ($article === null) {
			throw new Exc404('article not found');
		}

		$this->content = $this->view->render('Articles//Views/v_item.twig', ['article' => $article]);
	}

	public function add()
	{
		$fields = [];
		$errors = [];
		$this->title = 'New article';

		if($this->env['server']['REQUEST_METHOD'] === "POST") {
			try {
				$fields = [
					'title' => $this->env['post']['title'],
					'content' => $this->env['post']['content']
				];
				$id = $this->model->add($fields);
				header("Location: " . BASE_URL . "article/$id");
				exit();
			}
			catch (ExcValidation $e) {
				$bag = $e->getBag();
				$errors = $bag->firstOfAll();
			}
		}
			$this->content = $this->view->render('Articles//Views/v_add.twig', [
				'fields' => $fields,
				'errors' => $errors,
			]);
		
	}

	public function remove()
	{
		var_dump($this->model->remove(1));
	}

	public function edit()
	{
		$id = (int)$this->env['params']['id'];
		$article = $this->model->get($id);

		if ($article === null) {
			throw new Exc404('article not found');
		}

		$fields = ['title' => $article['title'], 'content' => $article['content']];
		$errors = [];

		$this->title = 'Edit article';

		if($this->env['server']['REQUEST_METHOD'] === "POST") {
			try {
				$fields = [
					'title' => $this->env['post']['title'],
					'content' => $this->env['post']['content']
				];
				$this->model->edit($id, $fields);
				header("Location: " . BASE_URL . "article/$id");
				exit();
			}
			catch (ExcValidation $e) {
				$bag = $e->getBag();
				$errors = $bag->firstOfAll();
			}
		}
			$this->content = $this->view->render('Articles//Views/v_add.twig', [
				'fields' => $fields,
				'errors' => $errors,
			]);
	}
}
<?php
namespace Modules\Articles\Controllers;
use Modules\_base\Controller as BaseC;
use System\Contracts\IStorage;

use System\FileStorage;
use System\Template;

class Index extends BaseC{
	protected IStorage $storage;

	public function __construct()
	{
		$this->storage = FileStorage::getInstance('db/articles.txt'); // yes-yes, without DI it is trash
	}

	public function index()
	{
		$this->title = 'Home page';
		$this->content = 'Articles list';

		parent::render();
	}

	public function item()
	{
		$this->title = 'Article page';
		$id = (int)$this->env[1];
		$article = $this->storage->get($id);

		$this->content = Template::render(__DIR__ . '/../Views/v_item.php', ['article' => $article]);
		parent::render();
	}
}
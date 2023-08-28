<?php

namespace Modules\Users\Controllers;

use Modules\_base\Controller as BaseController;

class Office extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		$this->checkAccess();
	}

	public function index()
	{
		$this->title = 'Office';
		$this->content =  'closed page';
	}

	public function profile()
	{
		$this->title = 'profile';
		$this->content =  'closed page, profile';
	}
}
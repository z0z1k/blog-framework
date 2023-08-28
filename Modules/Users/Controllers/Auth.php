<?php

namespace Modules\Users\Controllers;

use Modules\_base\Controller as BaseController;
use Modules\Users\Models\Index as ModelUsers;
use Modules\Users\Models\Sessions as Sessions;
use System\Session as SessionHelper;

class Auth extends BaseController
{
	protected ModelUsers $mUsers;
	protected Sessions $mSessions;

	public function __construct()
	{
		parent::__construct();
		$this->mUsers = ModelUsers::getInstance();
		$this->mSessions = Sessions::getInstance();
	}

	public function login()
	{
		$this->title = 'Login';
		$error = false;

		if($this->env['server']['REQUEST_METHOD'] == 'POST'){
			$login = trim($this->env['post']['login']);
			$password = trim($this->env['post']['password']);

			$user = $this->mUsers->getByLogin($login);

			if($user === null || !password_verify($password, $user['password'])){
				$error = true;
			}
			else{
				$fields = [
					'id_user' => $user['id_user'],
					'token' => $this->mSessions->generateToken()
				];

				$this->mSessions->add($fields); // try-catch to token duplicates
				setcookie('token', $fields['token'], time() + 3600 * 24 * 30, BASE_URL);
				SessionHelper::set('token', $fields['token']);
				header("Location: " . BASE_URL . 'office');
				exit();
			}
		}

		$this->content .=  $this->view->render('Users/Views/v_login.twig', [
			'error' => $error
		]);
	}
}
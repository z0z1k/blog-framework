<?php

namespace Modules\Users\Api;
use System\Session;
use Modules\Users\Models\Index as Users;
use Modules\Users\Models\Sessions as Sessions;

class Auth{
	public static function getUser() : ?array{
		$token = Session::get('token') ?? $_COOKIE['token'] ?? null;

		if($token === null){
			return null;
		}

		$mSession = Sessions::getInstance();
		$session = $mSession->getByToken($token);

		// all params not active session
		if($session === null || $session['status'] > 0){
			// clear identify
			return null;
		}

		return Users::getInstance()->get($session['id_user']);
	}
}
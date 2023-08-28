<?php

namespace Modules\Users\Models;

use System\Model;

class Sessions extends Model
{
	protected static $instance;
	protected string $table = 'oop_users_sessions';
	protected string $pk = 'id_session';

	protected array $validationRules = [
		'id_user' => 'required|numeric',
		'token' => 'required|min:64|max:64|unique' // please find range rule
	];

	public function generateToken(){
		return substr(bin2hex(random_bytes(128)), 0, 64);
	}

	public function getByToken(string $token) : ?array{
		$res = $this->selector()->where('token = :token', ['token' => $token])->get();
		return $res[0] ?? null;
	}
}
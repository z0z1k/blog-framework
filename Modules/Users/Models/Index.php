<?php

namespace Modules\Users\Models;

use System\Model;

class Index extends Model
{
	protected static $instance;
	protected string $table = 'oop_users_index';
	protected string $pk = 'id_user';

	protected array $validationRules = []; // to do for reg

	public function getByLogin(string $login) : ?array
	{
		$res = $this->selector()->where('login = :login', ['login' => $login])->get();
		return $res[0] ?? null;
	}
}
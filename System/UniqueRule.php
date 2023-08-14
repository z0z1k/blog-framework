<?php

namespace System;

use Rakit\Validation\Rule;
use System\Database\Connection;


class UniqueRule extends Rule
{
	protected $message = ":attribute :value has been used";
	protected $fillableParams = ['table', 'column', 'fk', 'id'];

	protected $db;

	public function __construct(Connection $db)
	{
		$this->db = $db;
	}

	public function check($value): bool
	{
		// make sure required parameters exists
		$this->requireParameters(['table', 'column']);

		// getting parameters
		$column = $this->parameter('column');
		$table = $this->parameter('table');
		$fk = $this->parameter('fk');
		$id = $this->parameter('id');

		$queryStr = "SELECT COUNT(*) as cnt from `{$table}` WHERE `{$column}` = :value";
		$queryVars = [ 'value' => $value ];

		if($fk !== null && $id !== null){
			$queryStr .= " AND $fk <> :id";
			$queryVars += ['id' => $id];
		}

		$query = $this->db->query($queryStr, $queryVars);
		$res = $query->fetch();
		return intval($res['cnt']) === 0;
	}
}

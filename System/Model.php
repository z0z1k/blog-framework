<?php

namespace System;

use System\DataBase\Connection;
use System\DataBase\QuerySelect;
use System\DataBase\SelectBuilder;

abstract class Model
{
    protected static $instance;
    protected Connection $db;
    protected string $table;
    protected string $fk;

    public static function getInstance() : static
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function all() : array
    {
        return $this->selector()->get();
    }

    public function selector() : QuerySelect
    {
        $builder = new SelectBuilder($this->table);
        return new QuerySelect($this->db, $builder);
    }
}
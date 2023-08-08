<?php

namespace System;

use System\DataBase\Connection;
use System\DataBase\QuerySelect;
use System\DataBase\SelectBuilder;
use System\Exceptions\ExcValidation;

abstract class Model
{
    protected static $instance;
    protected Connection $db;
    protected string $table;
    protected string $fk;
    protected array $validationRules;
    protected Validator $validator;

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
        $this->validator = new Validator($this->validationRules);

        var_dump($this->validationRules);
    }

    public function all() : array
    {
        return $this->selector()->get();
    }

    public function get(int $id) : ?array
    {
        $res = $this->selector()->where("{$this->fk} = :fk", ['fk' => $id])->get();
        return $res[0] ?? null;
    }

    public function add(array $fields) : int
    {
        $isValid = $this->validator->run($fields);

        if (!$isValid) {
            throw new ExcValidation();
        }

        $names = [];
        $masks = [];

        foreach ($fields as $field => $val) {
            $names[] = $field;
            $masks[] = ":$field";
        }

        $namesStr = implode(', ', $names);
        $masksStr = implode(', ', $masks);

        $query = "INSERT INTO {$this->table} ($namesStr) VALUES ($masksStr)";
        var_dump($query);
        $this->db->query($query, $fields);
        return $this->db->lastInsertId();
    }

    public function selector() : QuerySelect
    {
        $builder = new SelectBuilder($this->table);
        return new QuerySelect($this->db, $builder);
    }
}
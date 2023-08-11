<?php

namespace System;

use System\DataBase\Connection;
use System\DataBase\QuerySelect;
use System\DataBase\SelectBuilder;
use System\Exceptions\ExcValidation;
use Rakit\Validation\Validator;

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
        $this->validator = new Validator();
    }

    public function selector() : QuerySelect
    {
        $builder = new SelectBuilder($this->table);
        return new QuerySelect($this->db, $builder);
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
        $validation = $this->validator->validate($fields, $this->validationRules);

        if ($validation->fails()) {

            throw new ExcValidation("can't add article", $validation->errors());
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
        $this->db->query($query, $fields);
        return $this->db->lastInsertId();
    }

    public function remove(int $id) : bool
    {
        $query = "DELETE FROM {$this->table} WHERE {$this->fk} = :id";
        $query = $this->db->query($query, ['id' => $id]);
        return $query->rowCount() > 0;
    }

    public function edit(int $id, array $fields) : bool
    {
        $isValid = $this->validator->run($fields);
        var_dump($isValid);

        if (!$isValid) {
            throw new ExcValidation();
        }
        
        $pairs = [];

        foreach ($fields as $field => $val) {
            $pairs[] = "$field=:$field";
        }

        $pairsStr = implode(', ', $pairs);

        $query = "UPDATE {$this->table} SET $pairsStr WHERE {$this->fk} = :fk";
        $this->db->query($query, $fields + [$this->fk => $id]);
        return true;
    }
}
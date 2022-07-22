<?php

namespace App\Core;

use App\Core\Sql;
use PDO;

class QueryBuilder
{
    private $pdo;

    private $from;

    private $order = [];

    private $where = [];

    private $limit;

    private $fields = ["*"];

    private $params = [];

    public function __construct()
    {
        try {
            $this->pdo = new \PDO(DBDRIVER . ":host=" . DBHOST . ";port=" . DBPORT . ";dbname=" . DBNAME . ";charset=utf8mb4", DBUSER, DBPWD
                , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
        } catch (\Exception $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }

    public function from(string $table, string $alias = null): self
    {
        $table = DBPREFIXE . $table;
        $this->from = $alias === null ? $table : $table . " " . $alias;
        return $this;
    }

    public function where(string ...$where): self
    {

        $this->where = array_merge($this->where, $where);


        return $this;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }


    public function setParam(string $key, string $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }


    public function select(string ...$fields): self
    {
        if ($this->fields === ["*"]) {
            $this->fields = $fields;
        } else {
            $this->fields = array_merge($this->fields, $fields);
        }
        return $this;
    }

    public function innerJoin(string $table, string $condition): self
    {
        $table = DBPREFIXE . $table;
        $this->from .= " INNER JOIN " . $table . " ON  " . $condition;
        return $this;
    }

    public function limit(string $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function orderBy(string $key, string $direction): self
    {
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'])) {
            $this->order[] = $key;
        } else {
            $this->order[] = $key . " " . $direction;
        }
        return $this;
    }

    public function toSql(): string
    {
        $fields = implode(", ", $this->fields);
        $sql = "SELECT " . $fields . " FROM " . $this->from;
        if ($this->where) {
            $where = implode(" AND ", $this->where);
            $sql .= " WHERE " . $where;
        }
        if (!empty($this->order)) {
            $sql .= " ORDER BY " . implode(', ', $this->order);
        }

        if ($this->limit) {
            $sql .= " LIMIT " . $this->limit;
        }
        return $sql;
    }

    public function fetch(string $field = null)
    {
        $queryPrepared = $this->pdo->prepare($this->toSql());
        $queryPrepared->execute($this->params);
        if ($field) {
            $result = $queryPrepared->fetch($this->pdo::FETCH_ASSOC)[$field];
        } else {
            $result = $queryPrepared->fetch($this->pdo::FETCH_ASSOC);
        }
        return $result ?: null;
    }

    public function fetchAll(): array
    {
        $queryPrepared = $this->pdo->prepare($this->toSql());
        $queryPrepared->execute($this->params);
        return $queryPrepared->fetchAll($this->pdo::FETCH_ASSOC);
    }

    public function fetchAllByClass(string $className)
    {
        $queryPrepared = $this->pdo->prepare($this->toSql());
        $queryPrepared->execute($this->params);
        return $queryPrepared->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public function fetchByClass(string $className)
    {
        $queryPrepared = $this->pdo->prepare($this->toSql());
        $queryPrepared->execute($this->params);
        return $queryPrepared->fetchObject($className);
    }

    public function count(): int
    {
        return (int)(clone $this)->select('COUNT(id) count')->fetch('count');
    }
}


<?php


namespace App\Core;

use App\Interface\QueryBuilder as QueryBuilder;
use PDO;

class MysqlBuilder implements QueryBuilder
{
    private $pdo;
    private $query;
    private $fields = ["*"];


    public function __construct()
    {
        $this->pdo = Connexion::getInstance();
        $this->query = new \stdClass();
        $this->query->fields = ["*"];
        $this->query->params = [];
        $this->query->where = [];
        $this->query->order = [];
    }

    public function select(string ...$fields): QueryBuilder
    {
        if ($this->query->fields === ["*"]) {
            $this->query->fields = $fields;
        } else {
            $this->query->fields = array_merge($this->fields, $fields);
        }
        return $this;
    }

    public function from(string $table, string $alias = null): QueryBuilder
    {
        $this->query->from = $alias === null ? $table : $table . " " . $alias;

        return $this;
    }

    public function where(string ...$where): QueryBuilder
    {
        $this->query->where = array_merge($this->query->where, $where);
        return $this;
    }

    public function setParams(array $params): QueryBuilder
    {
        $this->query->params = $params;
        return $this;
    }

    public function setParam(string $key, string $value): QueryBuilder
    {
        $this->query->params[$key] = $value;
        return $this;
    }

    public function limit(string $limit): QueryBuilder
    {
        $this->query->limit = $limit;
        return $this;
    }

    public function orderBy(string $key, string $direction): QueryBuilder
    {
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'])) {
            $this->query->order[] = $key;
        } else {
            $this->query->order[] = $key . " " . $direction;
        }
        return $this;
    }

    public function innerJoin(string $table, string $condition): QueryBuilder
    {
        $this->query->from .= " INNER JOIN " . $table . " ON  " . $condition;
        return $this;
    }

    public function toSql(): string
    {


        $fields = implode(", ", $this->query->fields);
        $sql = "SELECT " . $fields . " FROM " . $this->query->from;
        if (!empty($this->query->where)) {
            $where = implode(" AND ", $this->query->where);
            $sql .= " WHERE " . $where;
        }
        if (!empty($this->query->order)) {
            $sql .= " ORDER BY " . implode(', ', $this->query->order);
        }
        if (!empty($this->query->limit)) {
            $sql .= " LIMIT " . $this->query->limit;
        }
        return $sql;

    }

    public function count(): int
    {
        return (int)(clone $this)->select('COUNT(id) count')->fetch('count');
    }


    public function fetch(string $field = null, $className = "stdClass")
    {
        $queryPrepared = $this->pdo->prepare($this->toSql());
        $queryPrepared->execute($this->query->params);
        if ($field) {
            return $queryPrepared->fetchObject($className)->$field;
        }
        return $queryPrepared->fetchObject($className);

    }

    public function fetchAll($className = "stdClass")
    {
        $queryPrepared = $this->pdo->prepare($this->toSql());
        $queryPrepared->execute($this->query->params);
        return $queryPrepared->fetchAll(PDO::FETCH_CLASS, $className);
    }


}
<?php

namespace App\Interface;


interface QueryBuilder
{
    public function select(string ...$fields): self;
    public function from(string $table, string $alias = null): self;
    public function where(string ...$where): self;
    public function setParams(array $params): self;
    public function setParam(string $key, string $value): self;
    public function limit(string $limit): self;
    public function orderBy(string $key, string $direction): self;
    public function innerJoin(string $table, string $condition): self;
    public function toSql(): string;
    public function fetch(string $field = null);
    public function fetchAll($className = "stdClass");
    public function count(): int;
}

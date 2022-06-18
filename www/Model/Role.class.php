<?php

namespace App\Model;

use App\Core\QueryBuilder;

class Role
{
    protected int $id;
    protected string $name;



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAll(): array
    {
        $query = new QueryBuilder();
        return $query->from('role')
            ->orderBy('id', 'ASC')
            ->fetchAll();
    }

}
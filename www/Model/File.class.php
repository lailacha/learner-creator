<?php


namespace App\Model;

use App\Core\Sql;
use App\Model\FileCategory;


class File extends Sql
{

    private $id;
    protected string $name;
    protected string $extension;
    protected int $category;
    protected $path;
    protected DateTime $created_at;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->title;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return FileCategory
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function setCreatedAt(DateTime $date): void
    {
        $this->created_at = $date;
    }


}
<?php


namespace App\Model;

use App\Core\Sql;
use App\Model\FileCategory;


class File extends Sql
{

    private string $title;
    private string $extension;
    private FileCategory $category;


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
     * @param FileCategory $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }


}
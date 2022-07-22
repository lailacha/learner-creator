<?php


namespace App\Model;


class FileCategory extends Sql
{

    private int $id;
    private string $title;
    private $minHeight;
    private $maxHeight;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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


    public function getCategory(): array
    {
        $array = [];
        $query = "SELECT name FROM ".$this->table." ORDER BY name ASC";
        $req = $this->pdo->prepare($query);
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $re) {
            $array[] = $re["name"];
        }
        return $array;
    }
}
<?php


namespace App\Model;

use App\Core\Sql;
use PDO;


class CourseCategory extends Sql
{
    protected  $id = null;
    protected $name;
    protected string $description;



    public function __construct()
    {
        parent::__construct();
        $this->table  = DBPREFIXE."course_category";
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

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCategory(): array
    {
        $query = "SELECT id, name FROM ".$this->table." ORDER BY name ASC";
        $req = $this->pdo->query($query);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryForm(): array
    {
      return ["config" => ["method" => "POST", "action" => "", "submit" => "Ajouter"],
              "inputs" => [
                  "name" => ["type" => "text", "placeholder" => "Nom de la catégorie", "required" => true],
                  "description" => ["type" => "text", "placeholder" => "Description de la catégorie", "required" => true]
              ]
      ];
    }
}
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
    public function getId(): ?int
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

    public function getCategories(): array
    {
        $query = "SELECT id, name FROM ".$this->table." ORDER BY name ASC";
        $req = $this->pdo->query($query);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCatNamePref($category): array
    {
        $query = "
        SELECT name FROM ".$this->table." WHERE id = :category";
        $req = $this->pdo->prepare($query);
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function getCategoryForm(): array
    {
      return ["config" => ["method" => "POST", "action" => "/save/category", "class" => "form" ,"submit" => "Ajouter"],
              "inputs" => [
                  "name" => ["type" => "text", "placeholder" => "Nom de la catégorie", "required" => true],
                  "description" => ["type" => "text", "placeholder" => "Description de la catégorie", "required" => true]
              ]
      ];
    }

    public function editCategory(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/update/category?category_id=" . $this->getId(),
                "id" => "formEditCategory",
                "enctype" => "multipart/form-data",
                "class" => "form course",
                "submit" => "Save Category"
            ],
            "inputs" => [
                "name" => [
                    "placeholder" => "Nom du chapitre",
                    "type" => "text",
                    "value" => $this->getName(),
                    "required" => true,
                    "error" => "Votre nom doit faire entre 15 et 20 caractères"
                ],
                "description" => [
                    "placeholder" => "",
                    "type" => "textarea",
                    "id" => "courseName",
                    "class" => "editable",
                    "required" => true,
                    "value" => $this->getDescription(),
                    "error" => "Votre nom doit faire entre 15 et 20 caractères"
                ],
                "category_id" => [
                    "type" => "hidden",
                    "value" => $this->getId(),
                ],
            ]
                ];
    }
}   

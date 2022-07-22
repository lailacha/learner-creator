# Process back-end CRUD

## 1. Création de l’entité en BDD (table)

- Identifiez les différents champs (via maquettes, discussion avec l’équipe)
- Créer la tables
- Ajoutez les champs

## 2. Création du model

Dans l’application, généralement chaque table a son propre model pour pouvoir facilement travailler avec les objets et qu’ils soient la représentation de nos tables en base de données.

- Dans le dossier model, créer le model `Model.class.php`
- Ajoutez toutes ses proprietés (champs de la bdd)
- Créer les getters et setters (php storm peut les générer pour vous)
- Dans un premier temps créez le formulaire de création (methode qui renvoit un tableau de config)

```bash
<?php

namespace App\Model;

use App\Core\Sql;

class Lesson extends Sql
{
  protected $id = null;
  protected string $title;
  protected int $video;
  protected string $text;
  protected int $user;
  protected int $chapter;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return null
     */
    public function getId()
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

    /**
     * @return int|string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param int|string $video
     */
    public function setVideo($video): void
    {
        $this->video = $video;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user): void
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getChapter(): int
    {
        return $this->chapter;
    }

    /**
     * @param int $chapter
     */
    public function setChapter(int $chapter): void
    {
        $this->chapter = $chapter;
    }

    public function getCreateLessonForm($course = null)
    {
        $i=0;
        $chapters = [];
        foreach ($course->getChapters() as $chapter) {
            $chapters[$i]["id"] = $chapter->getId();
            $chapters[$i]["name"] = $chapter->getName();
        }
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "enctype" => "multipart/form-data",
                "id" => "formLesson",
                "class" => "form",
                "submit" => "Create lesson"
            ],
            "inputs" => [
                "title" => [
                    "placeholder" => "Name of the lesson",
                    "type" => "text",
                    "id" => "titleLesson",
                    "class" => "",
                    "required" => true,
                ],
                "text" => [
                    "placeholder" => "Describe the lesson",
                    "type" => "textarea",
                    "class" => "editable",
                    "id" => "",
                    "required" => true,
                ],
                "video" => [
                    "type" => "file",
                    "id" => "course-video",
                    "class" => "file",
                    "required" => true,
                    "error" => " Votre image doit être de la bonne extension",
                ],
                "chapter" => [
                    "type" => "select",
                    "id" => "jjj",
                    "class" => "formRegister",
                    "required" => "true",
                    "options" => [
                        "data" =>
                            $chapters,
                        "property" => "name",
                        "value" => "id",
                        "selected" => 1

                    ]]
            ]
        ];
    }

}
```

> *Précision: si vous avez besoin de valeurs déjà existantes en bdd (par exemple un select des catégories) vous pouvez utilisez celles si en récuperant les valeurss existants en bdd puis en le passant au formulaire.*
>
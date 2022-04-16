<?php

namespace App\Model;

use App\Core\Sql;
use App\Model\CourseCategory;

class Course extends Sql
{
    protected  $id = null;
    protected $name;
    protected string $description;
    protected int $category;
    protected int $cover;
    protected int $user;




    /**
     * @return int
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

    public function __construct()
    {
        //echo "constructeur du Model User";
        parent::__construct();
    }


    public function save(): void
    {
        parent::save();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getName(): string
    {
        return $this->name;
    }



    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $descirption
     */
    public function setDescription(string $descirption): void
    {
        $this->description = $descirption;
    }

    /**
     * @return int
     */
    public function getCover(): int
    {
        return $this->cover;
    }

    /**
     * @param int $cover
     */
    public function setCover(int $cover): void
    {
        $this->cover = $cover;
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

    public function getCourseForm()
    {
        $categoryManager = new CourseCategory();
        return [
            "config" => [
                "method" => "POST",
                "action" => "createCourse",
                "id" => "formCreateCourse",
                "enctype" => "multipart/form-data",
                "class" => "form course",
                "submit" => "Save course"
            ],
            "inputs" => [
                "name" => [
                    "placeholder" => "Nom du cours",
                    "type" => "text",
                    "id" => "courseName",
                    "class" => "formCreateCourse",
                    "required" => true,
                    "error" => "Votre nom doit faire entre 15 et 20 caractères"
                ],
                "description" => [
                    "placeholder" => "",
                    "type" => "textarea",
                    "id" => "courseName",
                    "class" => "editable",
                    "required" => true,
                    "error" => "Votre nom doit faire entre 15 et 20 caractères"
                ],
                "cover" => [
                "type" => "file",
                "id" => "course-cover",
                "class" => "file",
                "error" => " Votre image doit être de la bonne extension",
            ],
//                "category" => [
//                    "type" => "select",
//                    "id" => "jjj",
//                    "class" => "formRegister",
//                    "options" => [
//                       "test" => ["libelle" => "Math", "value" => "1"],
//                       "test2" => [ "libelle" => "French ", "value" => "2",  "selected" => "selected"]],
//
//            ]
                "category" => [
                    "type" => "select",
                    "id" => "jjj",
                    "class" => "formRegister",
                    "options" => [
                     "data" =>
                         $categoryManager->getCategory(),
                        "property" => "name",
                         "value" => "id",
                        "selected" => 1

            ]]]];
    }



}

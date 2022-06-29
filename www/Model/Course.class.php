<?php

namespace App\Model;

use App\Core\Sql;
use App\Core\QueryBuilder;
use App\Model\CourseCategory;
use App\Model\CourseChapter;
use App\Model\File;
use App\Model\File as FileModel;

class Course extends Sql
{
    protected $id = null;
    protected $name;
    protected string $description;
    protected $created_at;
    protected int $category;
    protected int $cover;
    protected int $user;
    protected ?int $status;


    public function __construct()
    {
        parent::__construct();
    }

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
    public function getCover()
    {
        return $this->cover;
    }


    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @param int $cover
     */
    public function setCover(int $cover): void
    {
        $this->cover = $cover;
    }


    public function cover(): ?string
    {
        $fileManager = new FileModel();
        if ($this->getCover() !== null) {


            return $fileManager->getBy('id', $this->getCover())->getPath();
        }

        return null;
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
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    public function getUnapprovedCoursesByUser($user_id)
    {
        $query = new QueryBuilder();
        return $query->select('*')
            ->from('course')
            ->where('user = :user')
            ->where('status = :status')
            ->setParams([
                'user' => $user_id,
                'status' => 0
            ])
            ->fetchAllByClass(Course::class);
    }

    // à optimiser avec un innerjoin au lieu de plusieurs requêtes
    public function getCategoryName(): string
    {
        $categoryManager = new CourseCategory();
        $category = $categoryManager->setId($this->getCategory());
        return $category->getName();
    }

    public function getChapters()
    {
        $CourseChapterManager = new CourseChapter();
        return $CourseChapterManager->getAllBy("course", $this->getId());
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
                    "required" => true,
                    "error" => " Votre image doit être de la bonne extension",
                ],
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

                    ]]

            ]];
    }

    public function getEditCourseForm()
    {
        $categoryManager = new CourseCategory();
        return [
            "config" => [
                "method" => "POST",
                "action" => "/edit/course?id=" . $this->getId(),
                "id" => "formEditCourse",
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
                "cover" => [
                    "type" => "file",
                    "id" => "course-cover",
                    "class" => "file",
                    "error" => " Votre image doit être de la bonne extension",
                ],
                "id" => [
                    "type" => "hidden",
                    "value" => $this->getId(),
                ],
                "category" => [
                    "type" => "select",
                    "id" => "jjj",
                    "class" => "formRegister",
                    "options" => [
                        "data" =>
                            $categoryManager->getCategory(),
                        "property" => "name",
                        "value" => "id",
                        "selected" => $this->getCategory()

                    ]]]];
    }


}

<?php

namespace App\Model;

use App\Core\Sql;
use App\Core\Helpers;
use App\Core\QueryBuilder;
use App\Model\CourseCategory;
use App\Model\CourseChapter;
use App\Model\Learner;
use App\Model\File as FileModel;

class Course extends Sql
{

    protected $id = null;
    protected $name;
    protected string $description;
    protected string $slug;
    protected $created_at;
    protected $deleted_at;
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

    /**
     * @return void
     */
    public function setSlug(): void
    {
        //verify if the slugify name is already used in the database
       if($this->getBy('slug', Helpers::slugify($this->name)))
         {
              $this->slug = $this->slug . '-' . $this->id;
         }
            else
            {
                $this->slug = Helpers::slugify($this->name);
            }
    }


    public function save(): void
    {
        //generate a slug
        $this->setSlug();
        parent::save();
        if (is_null($this->getId())) {
            $this->notify();
        }
    }

    public function notify(): void
    {
        $userManager = new User();
        $learnerManager = new Learner();

        //get all user who likes this category of course
        if($learnerManager->getAllUserPrefByCategory($this->category))

        $users = $userManager->getAllUsers();
        foreach($users as $user) {
            $user->update($this);
        }
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

    public function user(): User
    {
        $userManager = new User();
        return $userManager->setId($this->getUser());
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

    /**
     * @return ?string
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }


    public function setDeletedAt($deleted_at): void
    {
        $this->deleted_at = $deleted_at;
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


    public function getAllRequests(): array
    {
        $query = new QueryBuilder();
        return  $query->select('c.id, c.name, c.description, c.category, u.lastname, u.firstname')
            ->from('course c')
            ->innerJoin('user u', 'c.user = u.id')
            ->where('c.status = :status')
            ->where('c.deleted_at IS NULL')
            ->setParams([
                'status' => 0
            ])
            ->fetchAllByClass(Course::class);
    }

    public function searchCourse($name): array
    {
        $query = new QueryBuilder();
        return $query->select('c.id, c.name, c.description, c.category, f.path')
            ->from('course c')
            ->innerJoin('file f', 'c.cover = f.id')
            ->where( "c.name LIKE :name", "c.deleted_at IS NULL")
            ->setParams([
                'name' => '%' . $name . '%'
            ])
            ->fetchAll();
    }


    // à optimiser avec un innerjoin au lieu de plusieurs requêtes
    public function getCategoryName(): string
    {
        $categoryManager = new CourseCategory();
        $category = $categoryManager->setId($this->getCategory());
        return $category->getName();
    }


    public function getBySlug($slug) 
    {
        $query = new QueryBuilder();
         if($query->select('*')
            ->from('course')
            ->where('slug = :slug')
            ->setParams([
                'slug' => $slug
            ])){
                return $query->fetchByClass(Course::class);
            }
        return null;
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
                "action" => "save/course",
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
                            $categoryManager->getCategories(),
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
                "action" => "/update/course?id=" . $this->getId(),
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
                    "max" => "255",
                    "required" => true,
                    "error" => "Votre nom doit faire entre 15 et 20 caractères"
                ],
                "description" => [
                    "placeholder" => "",
                    "type" => "textarea",
                    "id" => "courseName",
                    "class" => "editable",
                    "max" => "500",
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
                            $categoryManager->getCategories(),
                        "property" => "name",
                        "value" => "id",
                        "selected" => $this->getCategory()

                    ]]]];
    }
    
    public function getCourseReduce($course)
    {
        
        if (strlen($course)>50) 
        {
        $course=substr($course, 0, 50);
        $dernier_mot=strrpos($course," ");
        $course=substr($course,0,$dernier_mot);
        $course.="<a href= \"/show/course?id=".$this->id." \" > See more...</a>";
        return $course;
        
        }else{
            $course.="<a href= \"/show/course?id=".$this->id." \" > See more...</a>";
            return $course;
        }
        
    }




}

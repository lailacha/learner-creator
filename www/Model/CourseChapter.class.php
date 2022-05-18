<?php


namespace App\Model;

use App\Core\Sql;
use App\Model\Lesson;
use PDO;



class CourseChapter extends Sql
{
    protected  $id = null;
    protected $name;
    protected string $description;
    protected int $course;

    /**
     * @param int $course
     */
    public function setCourse(int $course): void
    {
        $this->course = $course;
    }

    /**
     * @return int
     */
    public function getCourse(): int
    {
        return $this->course;
    }

    public function __construct()
    {
        parent::__construct();
        $this->table  = DBPREFIXE."course_chapter";
    }
    /**
     * @return int
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

    public function getChapter()
    {
        $query = "SELECT id, name FROM ".$this->table." ORDER BY name ASC";
        $req = $this->pdo->prepare($query);
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function getLessons()
    {
        $courseLessonManager = new Lesson();
        return $courseLessonManager->getAllBy("chapter", $this->getId());
    }

    public function getChapterForm(): array
    {
        return ["config" => ["method" => "POST", "class" => "form" ,"action" => "/create/chapter?course_id=".$this->getCourse(), "submit" => "Save"],
            "inputs" => [
                "name" => ["type" => "text", "placeholder" => "Nom du chapitre", "required" => true],
                "description" => ["type" => "text", "placeholder" => "Description du chapitre", "required" => true],
                "course_id" => ["type" => "hidden", "value" => $this->getCourse()],
            ]
        ];
    }
}
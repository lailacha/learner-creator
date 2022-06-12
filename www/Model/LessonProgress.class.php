<?php


namespace App\Model;

use App\Core\Sql;

class LessonProgress extends Sql
{

    protected ?int $id = null;
    protected int $user;
    protected int $lesson;

    public function __construct()
    {
        parent::__construct();
        $this->setTable(DBPREFIXE . "user_progress_lesson");
    }

 
    /**
     * @return int | null
     */
    public function getId(): ?int
    {
        return $this->id;
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
    public function getLesson(): int
    {
        return $this->lesson;
    }

    /**
     * @param int $lesson
     */
    public function setLesson(int $lesson): void
    {
        $this->lesson = $lesson;
    }

    public function getUserProgress($lesson, $user)
    {
        return $this->getOneByMany(["lesson" => $lesson, "user" =>  $user]) ?  true : false;
    }

}
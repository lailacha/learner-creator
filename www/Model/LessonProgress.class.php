<?php


namespace App\Model;

use App\Model\User;
use App\Model\Course;
use App\Core\Sql;
use App\Core\QueryBuilder;


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

    public function getLastProgressLesson()
    {

        $query = new QueryBuilder();

        $last = $query->from('user_progress_lesson')
            ->where("id=(SELECT max(id) FROM " . DBPREFIXE . "user_progress_lesson)")
            ->fetchByClass('App\Model\LessonProgress');

            return $last;
    }


    public function getLastLessons()
    {
            $query = new QueryBuilder();
                $last = $query ->select('l.id, c.name, c.cover, c.id, c.description ')
                ->from('user_progress_lesson p')
                ->innerJoin('lesson l', 'p.lesson = l.id')
                ->innerJoin('course_chapter cc', 'cc.id = l.chapter')
                ->innerJoin('course c', 'cc.course = c.id')
                ->where('p.user = :user')
                ->setParams([
                    'user' => User::getUserConnected()->getId()
                ])
                ->fetchAllByClass(Course::class);

            return $last;
    }

}
<?php

namespace App\Model;

use App\Core\Sql;
use App\Core\QueryBuilder;
use App\Model\Lesson as lessonManager;

class LessonCommentaire extends Sql
{
    protected  $id = null;
    protected string $content;
    protected string $created_at;
    protected int $user;
    protected int $lesson;

    public function __construct()
    {
        $this->getPDO();
        $this->table  = DBPREFIXE."commentaire_lesson";
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
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
     * @return lessonManager
     */
    public function lesson()
    {
        $lessonManger = new lessonManager();
        return $lessonManger->setId($this->lesson);
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

    public function getWithUserByLesson($lesson) : array
    {
        $query = new QueryBuilder();
        return  $query->select('firstname as userFirstname, lastname as userLastname, content, created_at')
            ->from('commentaire_lesson')
            ->innerJoin('user', DBPREFIXE.'user.id ='.DBPREFIXE.'commentaire_lesson.user')
            ->where('lesson = :lesson')
            ->setParams([
                'lesson' => $lesson
            ])
            ->fetchAllByClass(__CLASS__);
    }

    public function showReportsComments(): array
    {
        $query = new QueryBuilder();
        return  $query->select('*')
            ->from('commentaire_lesson')
            ->where('reports > 0')
            ->fetchAllByClass(__CLASS__);
    }


    public function getCommentaireForm(int $lessonId)
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/create/comment",
                "class" => "form inline comment col-md-12 jc-sb",
                "submit" => "Add a comment",
                "enctype" => "multipart/form-data",
            ],
            "inputs" => [
                    "content" => [
                    "type" => "textarea",
                    "id" => "content",
                    "placeholder" => "Content",
                    "class" => "form-control m-3 comment",
                    "required" => true,
                ],
                "lesson_id" => [
                    "type" => "hidden",
                    "id" => "lesson",
                    "value" => $lessonId,
                ],

            ]
        ];
    }

}

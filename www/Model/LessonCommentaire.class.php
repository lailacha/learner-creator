<?php

namespace App\Model;

use App\Core\FormBuilder;
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
        parent::__construct();
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

    public function user()
    {
        $user = new User();
        return $user->setId($this->user);
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
        return  $query->select('c.id, firstname as userFirstname, lastname as userLastname, content, created_at,  esgi_file.path as avatar')
            ->from('commentaire_lesson c')
            ->innerJoin('user u', 'u.id = c.user')
            ->innerJoin('file', 'u.avatar = esgi_file.id')
            ->where('lesson = :lesson')
            ->setParams([
                'lesson' => $lesson
            ])
            ->fetchAllByClass(__CLASS__);
    }

    public function showReportsComments(): array
    {

        $query = new QueryBuilder();
        return  $query->select('U.firstname as userReportFirstname, U.lastname as userReportLastname, US.firstname as userFirstname, US.lastname as userLastname, content, created_at')
            ->from('report_comment RC')
            ->innerJoin('user U ', 'U.id =RC.user')
            ->innerJoin('commentaire_lesson CL ', 'CL.id = RC.id ')
            ->innerJoin('user US ', 'CL.user = US.id')
            ->fetchAllByClass(ReportComment::class);
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

    public function showCommentForm()
    {
        return FormBuilder::render($this->getReportForm());
    }

    public function getReportForm(): array
    {
        return ["config" => ["method" => "POST", "class" => "form" ,"action" => "/reportComment", "submit" => "Report comment",],
            "inputs" => [
                "reason" => ["type" => "textarea", "class"=>"editable", "required" => true],
                "comment_id" => ["type" => "hidden", "value" => $this->getId()],
            ]
        ];
    }

}

<?php


namespace App\Model;


use App\Core\FormBuilder;
use App\Core\Sql;

class ReportComment  extends Sql
{

    protected ?int $id = null;
    protected string $reason;
    protected int $user;
    protected int $comment;

    public function __construct()
    {
        parent::__construct();
        $this->setTable(DBPREFIXE . "report_comment");
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
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
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
        $user = new User();
        return $user->setId($this->getUser());
    }

    /**
     * @return int
     */
    public function getComment(): int
    {
        return $this->comment;
    }

    /**
     * @param int $comment
     */
    public function setComment(int $comment): void
    {
        $this->comment = $comment;
    }


    public function comment()
    {
        $commentaireManager = new LessonCommentaire();

       return $commentaireManager->setId($this->getComment());
    }


    public function getReportForm(): array
    {
        return ["config" => ["method" => "POST", "class" => "form" ,"action" => "/reportComment", "submit" => "disabled"],
            "inputs" => [
                "reason" => ["type" => "textarea", "class"=>"editable", "required" => true],
            ]
        ];
    }




}
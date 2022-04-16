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
  protected int $course;

    /**
     * Lesson constructor.
     * @param null $id
     * @param string $title
     * @param string $video
     * @param string $text
     * @param int $user
     * @param int $course
     */
    public function __construct($id, string $title, string $video, string $text, int $user, int $course)
    {

        parent::__construct();
        $this->id = $id;
        $this->title = $title;
        $this->video = $video;
        $this->text = $text;
        $this->user = $user;
        $this->course = $course;
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
    public function getCourse(): int
    {
        return $this->course;
    }

    /**
     * @param int $course
     */
    public function setCourse(int $course): void
    {
        $this->course = $course;
    }


    public function getCreateLessonForm()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "formLesson",
                "class" => "formLesson",
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
                    "type" => "text",
                    "id" => "",
                    "class" => "",
                    "required" => true,
                ],
                "text" => [
                    "placeholder" => "Describe the lesson",
                    "type" => "text",
                    "id" => "",
                    "class" => "",
                    "required" => true,
                ]
            ]
        ];
    }

}
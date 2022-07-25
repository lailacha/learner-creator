<?php


namespace App\Model;

use App\Core\Helpers;
use App\Core\Sql;
use App\Model\Course as CourseManager;
use App\Model\User as UserManager;
use App\Model\CourseChapter as ChapterManager;


class Lesson extends Sql
{
    protected $id = null;
    protected string $title;
    protected ?int $video;
    protected string $text;
    protected int $user;
    protected int $chapter;
    protected string $slug;
    protected string $created_at;



    public function __construct()
    {
        parent::__construct();
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
     * @return int|null $video
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

    public function user()
    {
        $userManger = new UserManager();
        return $userManger->setId($this->user);
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
    public function getChapter(): int
    {
        return $this->chapter;
    }

    public function chapter(): ChapterManager
    {
        $chapterManager = new ChapterManager();
        return $chapterManager->setId($this->chapter);
    }

    /**
     * @param int $chapter
     */
    public function setChapter(int $chapter): void
    {
        $this->chapter = $chapter;
    }

    public function course(): CourseManager
    {
        $courseManager = new CourseManager();
        return $courseManager->setId($this->chapter()->getCourse());
    }

    public function save(): void
    {
        //generate a slug
        $this->setSlug();
        parent::save();
    }

    /**
     * @return void
     */
    public function setSlug(): void
    {
        //verify if the slugify name is already used in the database
       if($this->getBy('slug', Helpers::slugify($this->title)))
         {
              $this->slug = $this->slug . '-' . $this->id;
         }
            else
            {
                $this->slug = Helpers::slugify($this->title);
            }
    }


    public function editLesson()
    {

        $i = 0;
        $chapters = [];
        foreach ($this->course()->getChapters() as $chapter) {
            $chapters[$i]["id"] = $chapter->getId();
            $chapters[$i]["name"] = $chapter->getName();
            $i++;
        }

        return [
            "config" => [
                "method" => "POST",
                "action" => "/update/lesson",
                "enctype" => "multipart/form-data",
                "id" => "formLesson",
                "class" => "form",
                "submit" => "Update lesson"
            ],
            "inputs" => [
                "title" => [
                    "placeholder" => "Name of the lesson",
                    "type" => "text",
                    "id" => "titleLesson",
                    "value" => $this->getTitle(),
                    "class" => "",
                    "required" => true,
                ],
                "text" => [
                    "placeholder" => "Describe the lesson",
                    "class" => "editable",
                    "type" => "textarea",
                    "value" => $this->getText(),
                    "id" => "",
                    "required" => true,
                ],
                "video" => [
                    "type" => "file",
                    "id" => "course-video",
                    "class" => "file",
                    "error" => " Votre image doit être de la bonne extension (mp4)",
                ],
                "lesson_id" => [
                    "type" => "hidden",
                    "value" => $this->getId(),
                ],
                "chapter" => [
                    "type" => "select",
                    "id" => "jjj",
                    "class" => "formRegister",
                    "required" => "true",
                    "options" => [
                        "data" =>
                            $chapters,
                        "property" => "name",
                        "value" => "id",
                        "selected" => $this->getChapter()

                    ]]
            ]
        ];
    }


    public function getCreateLessonForm(Course $course)
    {
        $i = 0;
        $chapters = [];
        foreach ($course->getChapters() as $chapter) {
            $chapters[$i]["id"] = $chapter->getId();
            $chapters[$i]["name"] = $chapter->getName();
            $i++;
        }

        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "enctype" => "multipart/form-data",
                "id" => "formLesson",
                "class" => "form",
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
                    "type" => "textarea",
                    "class" => "editable",
                    "id" => "",
                    "required" => true,
                ],
                "video" => [
                    "type" => "file",
                    "id" => "course-video",
                    "class" => "file",
                    "error" => " Votre image doit être de la bonne extension",
                ],
                "chapter" => [
                    "type" => "select",
                    "id" => "jjj",
                    "class" => "formRegister",
                    "required" => "true",
                    "options" => [
                        "data" =>
                            $chapters,
                        "property" => "name",
                        "value" => "id",
                        "selected" => 1

                    ]],
                    "course_id" => [
                        "value" => $course->getId(),
                        "type" => "hidden",
                    ]  
            ]
        ];
    }

}
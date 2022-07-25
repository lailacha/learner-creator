<?php


namespace App\Controller;

use App\Model\LessonCommentaire;
use App\Model\LessonProgress;
use App\Model\CourseChapter as CourseChapterModel;
use App\Model\Lesson as LessonManager;
use App\Model\Course as CourseManager;
use App\Model\File as FileManager;
use App\Model\ReportComment as ReportCommentModel;
use App\Model\User;
use App\Model\CourseChapter as ChapterManager;
use App\Core\FormBuilder;
use App\Core\HttpRequest;
use App\Core\Verificator;
use App\Controller\BaseController;
use App\Core\View;
use App\Service\File as FileService;
use App\Core\File;



class Lesson extends BaseController
{

    public function index()
    {
        $courseId = $this->request->get('course_id');
   
        $courseManager = new CourseManager();
        $course = $courseManager->setId($courseId);
        $lessonManager = new LessonManager();
        $form = FormBuilder::render($lessonManager->getCreateLessonForm($course));


        //form for chapter
        $course = $courseManager->setId($courseId);
        $chapterManager = new CourseChapterModel();
        if (!$course) {
            $this->session->addFlashMessage("error", "Course not found");
            $this->abort();
        }
        $chapterManager->setCourse($courseId);
        $formChapter = FormBuilder::render($chapterManager->getChapterForm());

        $view = new View("createLesson", "front");
        $view->assign('form', $form);
        $view->assign('formChapter', $formChapter);
    }

    public function getOneLesson()
    {
        $lessonId = $this->request->get('lesson_id');
        $lessonManager = new LessonManager();
        $fileManager = new FileManager();
        $lessonProgressManager = new LessonProgress();
        $lesson = $lessonManager->setId($lessonId);

        if($lessonId !== null)
        {
            $lesson = $lessonManager->setId($lessonId);
        }
        else{
            $lesson = $lessonManager->getBySlug($this->request->getSlug());
        }

        if(!$lesson){
            $this->session->addFlashMessage("error", "Lesson not found");
            $this->route->redirect('/404');
        }
        $view = new View("oneLesson", "front");
        if ($lesson->getVideo() != null) {
            $video = $fileManager->getBy('id', $lesson->getVideo())->getPath();
            $view->assign('video', $video);
        }

        $commentaireManager = new LessonCommentaire();
        $commentaireForm = FormBuilder::render($commentaireManager->getCommentaireForm($lesson->getId()));
        $comments = $commentaireManager->getWithUserByLesson($lesson->getId());
        $progressState = $lessonProgressManager->getUserProgress($lesson->getId(), User::getUserConnected()->getId());

        $chapters = $lesson->course()->getChapters();
        $reportCommentModel = new ReportCommentModel();

        $formReport = FormBuilder::render($reportCommentModel->getReportForm());
        $view->assign('progressState', $progressState);
        $view->assign('formReport', $formReport);
        $view->assign('comments', $comments);
        $view->assign('form', $commentaireForm);
        $view->assign('lesson', $lesson);
        $view->assign('chapters', $chapters);
    }


    public function create()
    {
        $LessonManager = new LessonManager();
        $courseManager = new CourseManager();
        $course = $courseManager->setId($this->request->get("course_id"));
  
        $verification = Verificator::checkForm($LessonManager->getCreateLessonForm($course), $this->request);
        if ($verification) {
            $this->session->addFlashMessage("error", $verification[0]);
            return $this->route->redirect("/createLesson");
        }

        $LessonManager->setTitle($this->request->get("title"));
        $LessonManager->setText($this->request->get("text"));
        $LessonManager->setChapter($this->request->get("chapter"));
        $LessonManager->setUser(User::getUserConnected()->getId());


        if ($this->request->get("video") !== null && isset($_FILES['video']) && $_FILES['video']['error'] === 0) {
            $file = new FileService($_FILES["video"]);

            try {
                $file = $file->upload("lessons", 2, true);
                $LessonManager->setVideo($file->getLastInsertId());
            } catch (\Exception $e) {
                $this->session->addFlashMessage("error", $e->getMessage());
                return $this->route->redirect("/createCourse");
            }
        }
        $LessonManager->save();
        $this->session->addFlashMessage("success", "Votre lesson " . $LessonManager->getTitle() . " a bien été créé");
        $this->route->redirect("/show/lesson?lesson_id=" . $LessonManager->getLastInsertId());
    }

    public function edit()
    {
        $lessonManager = new LessonManager();
        $lesson = $lessonManager->setId($this->request->get('lesson_id'));
        $form = FormBuilder::render($lesson->editLesson());

        $view = new View("editLesson", "front");
        $view->assign('form', $form);
        $view->assign('lesson', $lesson);
    }

    public function update()
    {
        $lessonManager = new LessonManager();

        $lesson = $lessonManager->setId($this->request->get('lesson_id'));

        $errors = Verificator::checkForm($lesson->editLesson(), $this->request);

        if (!$errors) {
            if (!empty($this->request->get("title") && $this->request->get("title") !== $lesson->getTitle())) {
                $lesson->setTitle($this->request->get("title"));
            }

            if (!empty($this->request->get("text") && $this->request->get("text") !== $lesson->getText())) {
                $lesson->setText($this->request->get("text"));
            }

            if (!empty($this->request->get("chapter") && $this->request->get("chapter") !== $lesson->getChapter())) {
                $lesson->setChapter($this->request->get("chapter"));
            }

            if (!empty($this->request->get("video") && $this->request->get("video") !== $lesson->getVideo()) && isset($_FILES['video']) && $_FILES['video']['error'] === 0) {

                try {
                    $file = new FileService($_FILES["video"]);
                    $file = $file->upload("lessons", 2, true);
                } catch (\Exception $e) {
                    $this->session->addFlashMessage("error", $e->getMessage());
                    return;
                }
                $lesson->setVideo($file->getLastInsertId());
            }

            $lesson->save();
            $this->session->addFlashMessage("success", "Your Lesson has been updated");
            $this->route->redirect("/show/lesson?lesson_id=" . $lesson->getId());
        } else {
            $this->session->addFlashMessage("error", $errors[0]);
        }
    }

    public function completeLesson()
    {
        
        $this->session->addFlashMessage("success", "Your Lesson has been completed");
        $this->route->redirect("/show/lesson?lesson_id=" . $lesson->getId());
    }


    public function delete()
    {
        $lessonManager = new LessonManager();
        $lesson = $lessonManager->setId($this->request->get("lesson_id"));
        $lesson->delete();
        $this->session->addFlashMessage("success", "Your Lesson has been deleted");
        $this->route->redirect("/show/course?id=" . $lesson->chapter()->getCourse());
    }

}
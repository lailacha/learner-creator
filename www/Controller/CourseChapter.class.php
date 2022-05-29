<?php


namespace App\Controller;

use App\Controller\BaseController;
use App\Core\FormBuilder;
use App\Core\View;
use App\Core\Verificator;
use App\Model\CourseChapter as CourseChapterModel;
use App\Model\Course;




class CourseChapter extends BaseController
{

    public function create()
    {
        $course_id = $this->request->get('course_id');
        $courseManager = new Course();
        $course = $courseManager->setId($course_id);
        $chapterManager = new CourseChapterModel();
        if(!$course) {
            http_response_code(404);
            $this->addFlashMessage("error", "Course not found");

            //$this->redirect("/course");
        }

        $chapterManager->setCourse($course->getId());
        $form =  FormBuilder::render($chapterManager->getChapterForm());
        $view = new View("createChapter");
        $view->assign("form", $form);
        $view->assign("course_id", $course_id);
        $view->assign("course", $course);


        if(!empty($_POST)){
            $verification = Verificator::checkForm($chapterManager->getChapterForm(), $this->request);
            if($verification){
                $this->session->addFlashMessage("error", $verification[0]);
            }
            else{
                $chapterManager->setName($this->request->get('name'));
                $chapterManager->setDescription($this->request->get('description'));
                $chapterManager->save();
                $this->session->addFlashMessage("success", "Chapter created");
                $this->route->goBack();
            }

        }



    }
}
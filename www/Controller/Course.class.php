<?php


namespace App\Controller;

use App\Model\Course as CourseModel;
use App\Model\User;
use App\Model\File as FileManager;
use App\Model\CourseCategory as CourseCategory;
use App\Core\FormBuilder;
use App\Core\HttpRequest;
use App\Core\Verificator;
use App\Controller\BaseController;
use App\Core\View;
use App\Service\File;



class Course extends BaseController
{


    public function index()
    {
        //get All the courses
        $courseManager = new CourseModel();
        $form = FormBuilder::render($courseManager->getCourseForm());
        $view = new View("createCourse", "front");
        $allCourses = $courseManager->getUnapprovedCoursesByUser(User::getUserConnected()->getId());
        $view->assign("form", $form);
        $view->assign("allCourses", $allCourses);

    }

    public function myCourse()
    {
        $courseManager = new CourseModel();
        $view = new View("myCourse", "front");
        $courses = $courseManager->getAllBy("user", User::getUserConnected()->getId());
        $view->assign("courses", $courses);
    }

    //TODO create view for this
    public function showAll()
    {
        $courseManager = new CourseModel();
        $courses = $courseManager->getAll();

        $view = new View("showAll", "front");
        $view->assign("index", $courses);
    }

    public function delete()
    {
        $courseManager = new CourseModel();
        $course = $courseManager->setId($this->request->get("id"));
        $course->delete();
        $this->route->goBack();
    }

    public function edit()
    {
        $courseManager = new CourseModel();
        $course = $courseManager->setId($this->request->get("id"));
        $form = FormBuilder::render($course->getEditCourseForm());
        $view = new View("editCourse", "front");


        if(!empty($_POST))
        {
            $verification = Verificator::checkForm($course->getEditCourseForm(), $this->request);
            if(!$verification)
            {
                if(!empty($this->request->get("name") && $this->request->get("name") != $course->getName()))
                {
                    $course->setName($this->request->get("name"));
                }

               if(!empty($this->request->get("description") && $this->request->get("description") != $course->getDescription()))
                {
                    $course->setDescription($this->request->get("description"));
                }

                if(!empty($this->request->get("category") && $this->request->get("category") != $course->getCategory()))
                {
                    $course->setCategory($this->request->get("category"));
                }

                if(!empty($this->request->get("cover") && $this->request->get("cover") != $course->getCover()))
                {
                    if(isset($_FILES['cover']) && $_FILES['cover']['error'] === 0){

                        try {
                            $file = new File($_FILES["cover"]);
                            $file = $file->upload( "thumbnails", 1);
                        } catch (\Exception $e) {
                             $this->session->addFlashMessage("error", $e->getMessage());
                            return;
                        }
                        $course->setCover($file->getLastInsertId());
                    }

                }

                $course->save();
                $this->session->addFlashMessage("success", "Votre cours a bien été modifié");
                $this->route->redirect("/show/course?id=".$course->getId(), "index");

            }
            else{
                $this->session->addFlashMessage("error",$verification[0]);
            }


        }
        $view->assign("form", $form);
        $view->assign("course", $course);
    }

    public function getOneCourse()
    {
        $courseManager = new CourseModel();

        try {
            $course = $courseManager->setId($this->request->get("id"));
        } catch (\Exception $e) {
            $this->session->addFlashMessage("error", "Ce cours n'existe pas");
            $this->route->redirect("/createCourse");
        }

            $view = new View("oneCourse", "front");
           return $view->assign("course", $course);

    }


    public function create()
    {

        $courseManager = new CourseModel();
        $verification = Verificator::checkForm($courseManager->getCourseForm(), $this->request);
        if($verification){
            $this->session->addFlashMessage("error", $verification[0]);
            $this->route->redirect("/createCourse");
        }

        try {

            if(isset($_FILES['cover']) && $_FILES['cover']['error'] === 0){
                $file = new File($_FILES["cover"]);
                $file = $file->upload( "thumbnails", 1);
                $courseManager->setCover($file->getLastInsertId());
             }

            $courseManager->setName($this->request->get("name"));
            $courseManager->setDescription($this->request->get("description"));
            $courseManager->setCategory($this->request->get("category"));
            $courseManager->setUser(User::getUserConnected()->getId());
            $courseManager->save();
            $courseName = $courseManager->getName();
        } catch (\Exception $e) {
            $this->session->addFlashMessage("error", "500 Internal Server Error");
            $this->route->goBack();
            return;
        }

        $this->session->addFlashMessage("success", "Votre cours ". $courseName." a bien été créé");
        $this->route->redirect("/createCourse");

    }

}
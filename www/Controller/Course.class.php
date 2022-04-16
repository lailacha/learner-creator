<?php


namespace App\Controller;

use App\Model\Course as CourseModel;
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
        $CourseCategoryManager = new CourseCategory();
        $courseManager = new CourseModel();

        $form = FormBuilder::render($courseManager->getCourseForm());

        $view = new View("createCourse", "front");
        $view->assign("form", $form);

    }


    public function create()
    {

        $courseManager = new CourseModel();
        $verification = Verificator::checkForm($courseManager->getCourseForm(), $this->request);
        if(!$verification){
            $courseManager->setName($this->request->get("name"));
            $courseManager->setDescription($this->request->get("description"));
            $courseManager->setCategory($this->request->get("category"));

            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
                $file = new File($_FILES["cover"]);
                $file = $file->upload( "thumbnails", 1);
                $courseManager->setCover($file->getLastInsertId());
            }

            // TODO REPLACE WITH USERCONNECT
            $courseManager->setUser(33);
            $courseManager->save();
        }

        $courseName = $courseManager->getName();
        $this->session->addFlash("success", "Votre cours ". $courseName." a bien été créé");
        $this->route->redirect("/createCourse");

    }

}
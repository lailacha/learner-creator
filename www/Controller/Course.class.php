<?php


namespace App\Controller;

use App\Model\Course as CourseModel;
use App\Model\CourseCategory as CourseCategory;
use App\Core\FormBuilder;
use App\Core\HttpRequest;
use App\Core\Verificator;
use App\Controller\BaseController;
use App\Core\View;
use App\Core\File;



class Course extends BaseController
{

    public function index()
    {
        $CourseCategoryManager = new CourseCategory();
        $courseManager = new CourseModel();

        $form = FormBuilder::render($courseManager->getCourseForm());

        $view = new View("createCourse", "back");
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
            $file = new File();
            $file->upload($_FILES["cover"], "thumbnails");
            $courseManager->save();
        }




        echo $verification[0] ?? "success";


    }

}
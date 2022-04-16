<?php


namespace App\Controller;

use App\Model\Lesson as LessonManager;
use App\Model\CourseCategory as CourseCategory;
use App\Core\FormBuilder;
use App\Core\HttpRequest;
use App\Core\Verificator;
use App\Controller\BaseController;
use App\Core\View;
use App\Core\File;



class Lesson extends BaseController
{

    public function index()
    {

    }


    public function create()
    {


        $LessonManager = new LessonManager();
        $verification = Verificator::checkForm($LessonManager->getCourseForm(), $this->request);
        if(!$verification){
            $LessonManager->setTitle($this->request->get("title"));
           $LessonManager->setText($this->request->get("text"));


           // TODO ADD USERCONNECT when available
           $LessonManager->setUser(33);


            //$LessonManager->setVideo()
            $file = new File();
            $file->upload($_FILES["cover"], "thumbnails");

            // TODO REMOVE WITH USERCONNECT
            $LessonManager->setUser(33);
            $LessonManager->save();


            // FEATURE ADD POSSIBILITY TO ADD IMAGE IN TEXT OF LESSON
        }

        echo $verification[0] ?? "success";


    }

}
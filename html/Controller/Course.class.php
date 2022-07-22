<?php


namespace App\Controller;

use App\Core\Mail;
use App\Model\Course as CourseModel;
use App\Model\LikeCourse as LikeModel;
use App\Model\User;
use App\Model\Learner;
use App\Model\File as FileManager;
use App\Core\FormBuilder;
use App\Core\Verificator;
use App\Core\View;
use App\Model\CourseCategory;
use App\Service\File;


class Course extends BaseController {

    public function index()
    {
        $courseManager = new CourseModel();
        $unaprovedCourses = $courseManager->getUnapprovedCoursesByUser(User::getUserConnected()->getId());

        $view = new View('courses/index');
        $view->assign('unaprovedCourses', $unaprovedCourses);

    }


    public function create()
    {
        $courseManager = new CourseModel();
        $form = FormBuilder::render($courseManager->getCourseForm());
        $view = new View('courses/createCourse');
        $view->assign('form', $form);
    }

    public function allCourses()
    {
        //get All the courses
        $courseManager = new CourseModel();
        $form = FormBuilder::render($courseManager->getCourseForm());
        $view = new View("courses/showAllCourses", "front");
        $allCourses = $courseManager->getUnapprovedCoursesByUser(User::getUserConnected()->getId());
        $view->assign("form", $form);
        $view->assign("allCourses", $allCourses);
        

    }

        public function searchCourse()
    {
        $courseManager = new CourseModel();
        $courses = $courseManager->searchCourse($this->request->get('course'));
        echo json_encode($courses);
    }

    public function myCourses()
    {
        $courseManager = new CourseModel();
        $view = new View("courses/myCourse", "front");
        $courses = $courseManager->getAllBy("user", User::getUserConnected()->getId());
        $view->assign("courses", $courses);
    }

    // Affiche tous les cours selon les préférences du users, ses favoris
    public function showAll()
    {
        $courseManager = new CourseModel();

        $courses = $courseManager->getAll();

        $view = new View("courses/showAllCourses", "front");
        $view->assign("courses", $courses);
    }


    public function showPreferences() {
        $courseManager = new CourseModel();
        $view = new View("showAll", "front");
        $user = User::getUserConnected()->getId();
        $learner = new Learner();
        $checkPref = $learner->checkPrefUser($user);

            if($checkPref == 1){
            $categoryPref = $learner->getAllCategories($user);
            $courses = $courseManager->getAll();
            $courseManager = $courseManager->getAll("category", $categoryPref);
            $view->assign("courseManager", $courseManager);
            }

         $like = new LikeModel();
         if ($like->getSaveLikes($user) > 0){
         $likeCourse = $like->getAllLike($user);
         $course = new CourseModel();
         $displayCourse = $course->getAllBy("id", $likeCourse); 
 
 
         $view->assign("displayCourse",$displayCourse);
          }

    }

    public function showByFavoriteCategory()
    {
        $courseManager = new CourseModel();
        $learner = new Learner();
        
        $user = User::getUserConnected()->getId();
        $categoryPref =$learner->getAllCategories($user);
        $courseManager = $learner->getAll('category', $categoryPref);

        $like = new LikeModel();
        $likeForm = FormBuilder::render($like->getCategoryLikeForm());
        
        $view = new View("showAll", "front");

        $view->assign("likeForm", $likeForm);
        $view->assign("courseManager", $courseManager);

        
        $like = new LikeModel();
        if ($like->getSaveLikes($user) == 0){
         }else{
        $likeCourse = $like->getAllLike($user);
        $course = new CourseModel();
        $displayCourse = $course->getAllBy("id", $likeCourse);
    }
    }
        

    public function delete()
    {
        $courseManager = new CourseModel();
        $course = $courseManager->setId($this->request->get("id"));
        $course->setDeletedAt(date('Y-m-d H:i:s'));
        $course->save();
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
                $this->route->redirect("/show/course?id=".$course->getId(), "index");
                $this->session->addFlashMessage("success", "Votre cours a bien été modifié");


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
            $course = $courseManager->getBySlug($this->request->getSlug());
            if($this->request->get("id") !== null)
            {
                $course = $courseManager->setId($this->request->get("id"));
            }
            else{
                $course = $courseManager->getBySlug($this->request->getSlug());
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
        $view = new View("oneCourse", "front");
       
            
           return $view->assign("course", $course);
           

    }


    public function save()
    {

        $courseManager = new CourseModel();
        $verification = Verificator::checkForm($courseManager->getCourseForm(), $this->request);
        if($verification){
            $this->session->addFlashMessage("error", $verification[0]);
            $this->route->goBack();
            return;
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
            $this->session->addFlashMessage("error", $e->getMessage());
            $this->route->goBack();
            return;
        }

        $this->session->addFlashMessage("success", "Votre cours ". $courseName." a bien été créé");
        $this->route->redirect("/createCourse");

    }


    public function showRequests()
    {
        $courseManager = new CourseModel();
        $courses = $courseManager->getAllRequests();
        $view = new View("courses/showCoursesRequests", "back");
        return $view->assign("courses", $courses);
    }

    public function verifyCourse(): void
    {
        $courseManager = new CourseModel();

        try{
            $course = $courseManager->setId($this->request->get("course_id"));
            if(!$course) {
                throw new \Exception("Ce cours n'existe pas");
            }
            $course->setStatus(1);
            $course->save();
        } catch (\InvalidArgumentException $e) {
            $this->session->addFlashMessage("error", $e->getMessage());
            $this->route->redirect("/show/courseRequests");
            die();
        }

        $html = "<h1>Votre cours {$course->getName()} a été validé</h1>";

        $confirmMail = new Mail();
        $confirmMail->setSubject("Félicitations! Votre cours a été validé");
        $confirmMail->setContent($html);
        $confirmMail->setApiKey(MAILJET_API_KEY);
        $confirmMail->setReceiver($course->user()->getEmail());
        $confirmMail->setReceiverName($course->user()->fullName());
        $confirmMail->sendMail();

        $this->session->addFlashMessage("success", "Le cours a bien été validé");
        $this->route->redirect("/show/courseRequests");


    }

    
    public function saveLike()
    {
        
            $LikeModel = new LikeModel();
            $LikeModel->setCourse($this->request->get("course"));
           $LikeModel->setUser(User::getUserConnected()->getId());
           $course = $LikeModel->getCourse();
           $user = $LikeModel->getUser();

            $like = $LikeModel->getSaveLike($course,$user);
 
            if ($like === 0){
            $LikeModel->save();
                header('Location: /show/course?id='.$course);
                $this->session->addFlashMessage("success", "Vous avez liké ce cours");
            }else {
                $LikeModel->deleteLike($course,$user);
                header('Location: /show/course?id='.$course);
                $this->session->addFlashMessage("success", "Vous avez disliké ce cours");
            } 
           
       
      
    }

}
<?php

namespace App\Controller;

use App\Core\Verificator;
use App\Model\RequestTeacher;
use App\Core\FormBuilder;
use App\Core\View;
use App\Core\HttpRequest;
use App\Service\File;


class Teacher extends BaseController
{

    public function index()
    {
        $requestTeacher = new RequestTeacher();
        $form = FormBuilder::render($requestTeacher->getCreateRequestForm());
        $view = new View("newTeacher");
        $view->assign("form", $form);
    }

    public function create(): void
    {

        $requestManager = new RequestTeacher();
        $verification = Verificator::checkForm($requestManager->getCreateRequestForm(), $this->request);
        if ($verification) {
            $this->session->addFlashMessage("error", $verification[0]);
            $this->route->redirect("/teacher/new");
        }
        try {
            if ($_POST && !empty($_POST) && !$verification && $_FILES['cv']['error'] === 0) {

                $file = new File($_FILES['cv']);
                $file = $file->upload("pdf", 4);
                $requestManager->setTheme($this->request->get('theme'));
                $requestManager->setMotivation($this->request->get('motivation'));
                $requestManager->setDiplome($this->request->get('diplome'));
                $requestManager->setUserId($this->request->get('user_id'));
                $requestManager->setCv($file->getLastInsertId());

            }
        } catch (\Exception $e) {
            $this->session->addFlashMessage("error", $e->getMessage());
            $this->route->goBack();

            return;
        }
        $requestManager->save();
        $this->session->addFlashMessage("success", "Votre demande a bien été envoyée");
        $this->route->goBack();


    }




}
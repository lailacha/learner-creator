<?php

namespace App\Controller;

use App\Core\FormBuilder;
use App\Core\View;
use App\Model\RequestTeacher;

class Teacher
{
    public function new()
    {
        $requestManager = new RequestTeacher();

        $view = new View("newTeacher");
        $form = FormBuilder::render($requestManager->getCreateRequestForm());
        if ($_POST){
            $requestManager->setUserId(15);
            $requestManager->setTheme($_POST['theme']);
            $requestManager->setIban($_POST['iban']);
            $requestManager->setMotivation($_POST['motivation']);
            $requestManager->save();
        }
        $view->assign("form", $form);
    }
}
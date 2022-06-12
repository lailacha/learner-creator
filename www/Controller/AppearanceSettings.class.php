<?php


namespace App\Controller;

use App\Controller\BaseController;
use App\Core\FormBuilder;
use App\Core\Verificator;
use App\Core\View;
use App\Service\File;


class AppearanceSettings extends BaseController
{

    public function index()
    {
        $settingsManager = new \App\Model\Settings();

        $form = FormBuilder::render($settingsManager->getSettingsForm());
        $view = new View("AppearanceSettings", "back");
        $view->assign("form", $form);
    }


    public function save()
    {
        $settingsManager = new \App\Model\Settings();
        $errors = Verificator::checkForm($settingsManager->getSettingsForm(), $this->request);

        if(!$errors)
        {

            if(!empty($this->request->get('main_color')) && $this->request->get('main_color') !== $settingsManager->getBy('id', 'main_color')->getValue())
            {
                $settings = $settingsManager->getBy('id', 'main_color');
                $settings->setValue($this->request->get('main_color'));
                $settings->save();
            }


            if(!empty($this->request->get('sidebar_color')) && $this->request->get('sidebar_color') !== $settingsManager->getBy('id', 'sidebar_color')->getValue())
            {
                $settings = $settingsManager->getBy('id', 'sidebar_color');
                $settings->setValue($this->request->get('sidebar_color'));
                $settings->save();
            }

            $this->session->addFlashMessage("success", "Settings has been updated");
            $this->route->redirect("/settings");

        }
        else{
            $this->session->addFlashMessage("error",$errors[0]);
            $this->route->redirect("/settings");

        }

    }
}
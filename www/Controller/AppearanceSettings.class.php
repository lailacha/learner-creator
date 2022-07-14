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

            if(!empty($this->request->get('primary_color')) && $this->request->get('primary_color') !== $settingsManager->getBy('id', 'primary_color')->getValue())
            {
                $settings = $settingsManager->getBy('id', 'primary_color');
                $settings->setValue($this->request->get('primary_color'));
                $settings->save();
            }

            if(!empty($this->request->get('big_title_size')) && $this->request->get('big_title_size') !== $settingsManager->getBy('id', 'big_title_size')->getValue())
            {
                $settings = $settingsManager->getBy('id', 'big_title_size');
                $settings->setValue($this->request->get('big_title_size'));
                $settings->save();
            }

            if(!empty($this->request->get('main_font')) && $this->request->get('main_font') !== $settingsManager->getBy('id', 'main_font')->getValue())
            {
        
                $settings = $settingsManager->getBy('id', 'main_font');
                $settings->setValue($this->request->get('main_font'));
                $settings->save();
            }

        
            if(!empty($this->request->get("logo")) && isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
                try {
                    $file = new File($_FILES["logo"]);
                    $file = $file->upload( "logo", 4);
                } catch (\Exception $e) {
                    $this->session->addFlashMessage("error", $e->getMessage());
                    $this->route->redirect("/AppearanceSettings");
                    return;
                }
                $settings = $settingsManager->getBy('id', 'logo');
                $settings->setValue($file->getLastInsertId());
                $settings->save();
            }
            

            $this->session->addFlashMessage("success", "Settings has been updated");
            $this->route->redirect("/AppearanceSettings");

        }
        else{
            $this->session->addFlashMessage("error",$errors[0]);
            $this->route->redirect("/AppearanceSettings");

        }

    }
}
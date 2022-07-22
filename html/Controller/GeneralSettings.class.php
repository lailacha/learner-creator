<?php


namespace App\Controller;

use App\Controller\BaseController;
use App\Core\FormBuilder;
use App\Core\Verificator;
use App\Core\View;
use App\Service\File;


class GeneralSettings extends BaseController
{
    
        public function index()
        {
            $settingsManager = new \App\Model\Settings();
    
            $form = FormBuilder::render($settingsManager->getGeneralSettingsForm());
            $view = new View("GeneralSettings", "back");
            $view->assign("form", $form);
        }


        public function save()
        {
            $settingsManager = new \App\Model\Settings();
            $errors = Verificator::checkForm($settingsManager->getGeneralSettingsForm(), $this->request);
    

            if(!$errors)
            {
    
                if(!empty($this->request->get('site_name')) && $this->request->get('site_name') !== $settingsManager->getBy('id', 'site_name')->getValue())
                {
                    $settings = $settingsManager->getBy('id', 'site_name');
                    $settings->setValue($this->request->get('site_name'));
                    $settings->save();
                }

                if(!empty($this->request->get('default_role')) && $this->request->get('default_role') !== $settingsManager->getBy('id', 'default_role')->getValue())
                {
                    $settings = $settingsManager->getBy('id', 'default_role');
                    $settings->setValue($this->request->get('default_role'));
                    $settings->save();
                }


                if(!empty($this->request->get('site_description')) && $this->request->get('site_description') !== $settingsManager->getBy('id', 'site_description')->getValue())
                {
                    $settings = $settingsManager->getBy('id', 'site_description');
                    $settings->setValue($this->request->get('site_description'));
                    $settings->save();
                }

                if(!empty($this->request->get('allow_comment')) && $this->request->get('allow_comment') !== $settingsManager->getBy('id', 'allow_comment')->getValue())
                {
                    $settings = $settingsManager->getBy('id', 'allow_comment');
  
                    $settings->setValue($this->request->get('allow_comment') === "allow"  ? "true" : "false");
                    $settings->save();
                }
    
                $this->session->addFlashMessage("success", "Settings has been updated");
                $this->route->redirect("/generalSettings");
    
            }
            else{
                $this->session->addFlashMessage("error",$errors[0]);
                $this->route->redirect("/generalSettings");
    
            }
        }
}
<?php

namespace App\Core;

use App\Model\Settings;

class View{

    private $view;
    private $template;
    private $data = [];

    public function __construct($view, $template="front")
    {
        $this->setView($view);
        $this->setTemplate($template);
       // $this->settings = new Settings();
    }

    public function setView($view):void
    {
        $this->view = $view;
    }
    public function setTemplate($template):void
    {
        $this->template = strtolower($template);
    }

    public function assign($key, $value):void
    {
        $this->data[$key]=$value;
    }

    public function includePartial($partial, $config): void
    {
        if(!file_exists("View/Partial/".$partial.".partial.php")){
            die("Le partial ".$partial." n'existe pas");
        }
        include "View/Partial/".$partial.".partial.php";
    }

    public function __toString():string
    {
        return "La vue c'est : ".$this->view. " et le template c'est : ".$this->template;
    }

    public function __destruct()
    {
            extract($this->data);
        include "View/".$this->template.".tpl.php";
        
    }

}
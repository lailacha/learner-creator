<?php

namespace App\Core;

interface Component
{
    public function greeting(): string;
}

class InstalleurGreeting implements Component
{
   public function greeting() : string
   {
     return "Bienvenue Voici votre installeur";
   }   

}







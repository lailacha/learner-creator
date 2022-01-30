<?php namespace App;

class Autoloader
{
    static function register()
    {
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }
    static function autoload($class){
        echo $class;
        $class = str_replace(__NAMESPACE__, "", $class);
        echo '<br/>'.$class;
        $class = (str_replace( '\\', '/', $class));
        $directory = lcfirst(explode("/", $class)[1]);
        $className = explode("/", $class)[2];
        echo '<br/>'.$directory;
        echo '<br/>'.$className;
        if(file_exists( $directory .'/'.$className. '.class.php')){
            require $directory .'/'.$className. '.class.php';
        }
    }
}

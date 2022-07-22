<?php namespace App\Exception;

class MultipleRouteFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Plusieurs routes ont été trouvées");
    }
}


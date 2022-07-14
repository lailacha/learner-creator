<?php 

namespace App\Exception;

class NoRouteFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Aucune route n'a été trouvée");
    }
}

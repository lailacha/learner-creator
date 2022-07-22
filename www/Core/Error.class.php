<?php

namespace App\Core;


class Error extends Decorator
{
    /**
     * Decorators may call parent implementation of the operation, instead of
     * calling the wrapped object directly. This approach simplifies extension
     * of decorator classes.
     */
    public function error(): string
    {
        return "(" . parent::greeting() . ") Tout vas bien vous avez déjà intaller l'application";
    }
}
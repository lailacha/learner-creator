<?php
namespace App\Core;


class Decorator implements Component
{
    /**
     * @var Component
     */
    protected $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    public function greeting():string
    {
        return $this->component->greeting();
    }


}
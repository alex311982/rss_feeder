<?php

namespace ComponentBundle\Components;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class Alert extends AbstractComponent
{
    static $name = 'Alert';

    protected $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function render(): string
    {
        return $this->templating->render('ComponentBundle:Components:alert.html.twig');
    }
}

<?php

namespace ComponentBundle\Components;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;

class News extends AbstractComponent
{
    static $name = 'News';

    protected $templating;

    protected $router;

    public function __construct(EngineInterface $templating, RouterInterface $router)
    {
        $this->templating = $templating;
        $this->router = $router;
    }

    public function render(): string
    {
        $component = static::getName();
        $ajaxUrl = $this->router->generate('AJAX_component', compact('component'));

        return $this->templating->render('ComponentBundle:Components:news.html.twig', [
            'ajax_url' => $ajaxUrl,
            'format' => 'json',
        ]);
    }


}

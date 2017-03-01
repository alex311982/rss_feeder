<?php

namespace AppBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Function;

class CategoryWidgetExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            "getCategories" => new Twig_Function($this, "getCategories")
            // register more functions
        );
    }

    public function getCategories()
    {

    }

    // Some more functions...

    public function getName()
    {
        return 'WidgetExtension';
    }
}
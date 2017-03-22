<?php

namespace ComponentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AlertController extends Controller
{
    public function indexAction(): Response
    {
        return $this->render('ComponentBundle:Components:alert.html.twig');
    }
}

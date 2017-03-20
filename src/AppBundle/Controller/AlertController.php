<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AlertController extends Controller
{
    public function indexAction(): Response
    {
        return $this->render('default/components/alert.html.twig', [
            'init_message' => 'wwwwwwwwwwwwwwwwwwwwwwww',
        ]);
    }
}

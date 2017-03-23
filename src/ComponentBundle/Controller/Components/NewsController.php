<?php

namespace ComponentBundle\Controller\Components;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    public function indexAction(): Response
    {
        return $this->render('ComponentBundle:Components:news.html.twig', [
            'ajax_url' => $this->generateUrl('AJAX_news'),
            'format' => 'json',
        ]);
    }
}

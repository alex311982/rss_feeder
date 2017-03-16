<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    public function indexAction(): Response
    {
        return $this->render('default/news.html.twig', [
            'ajax_url' => $this->generateUrl('AJAX_feeds'),
            'format' => 'json',
        ]);
    }
}

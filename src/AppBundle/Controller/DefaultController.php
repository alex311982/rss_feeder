<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $news = $this->redirect($this->generateUrl('AJAX_feeds', array('request' => $request)), 301);

        return $this->render('default/index.html.twig', [
            'news' => $news->getContent(),
            'ajax_url' => $this->generateUrl('AJAX_feeds'),
            'format' => 'json'
        ]);
    }
}

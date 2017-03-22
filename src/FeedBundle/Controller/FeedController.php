<?php

namespace FeedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FeedController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('FeedBundle:Components:index.html.twig', [
            'ajax_url' => $this->generateUrl('AJAX_feeds'),
            'format' => 'json',
            'page_header' => 'News'
        ]);
    }
}

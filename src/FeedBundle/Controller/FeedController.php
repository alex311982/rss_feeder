<?php

namespace FeedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FeedController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('FeedBundle:index:index.html.twig', [
            'page_header' => 'News'
        ]);
    }
}

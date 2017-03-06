<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function indexAction(): Response
    {
        return $this->render('default/categories.html.twig', [
            'ajax_url' => $this->generateUrl('AJAX_categories'),
            'format' => 'json',
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FeedEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function indexAction(): Response
    {
        return $this->render('default/categories.html.twig');
    }

    public function getCategoriesAction(Request $request): Response
    {
        $categories = $this->redirect($this->generateUrl('AJAX_categories', array('request' => $request)), 301);

        return $this->render('default/index.html.twig', [
            'categories' => $categories,
            'ajax_url' => $this->generateUrl('AJAX_categories'),
            'format' => 'json'
        ]);



        $categories = [];
        $news = $this->feedHandler->getFeeds();

        /** @var FeedEntity $new */
        foreach ($news as $new) {
            array_push($categories, [
                'name' => $new->getCategory(),
                'url' => $this->generateUrl('category', array('slug' => $new->getSlug())),
            ]);
        }
        $categories = array_unique($categories);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FeedEntity;
use AppBundle\Handler\FeedHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @var $feedHandler FeedHandler
     *
     * @DI\Inject("feed_handler")
     */
    protected $feedHandler;

    public function indexAction(): Response
    {
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

        return $this->render('default/categories.html.twig', [
            'categories' => $categories
        ]);
    }
}

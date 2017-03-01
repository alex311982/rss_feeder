<?php

namespace AppBundle\Controller;

use AppBundle\Handler\FeedHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    /**
     * @var $feedHandler FeedHandler
     *
     * @DI\Inject("feed_handler")
     */
    protected $feedHandler;

    public function indexAction(Request $request):Response
    {
        $feeds = $this->feedHandler->getFeedsByOffset($request->query->get('offset'));

        $response = new JsonResponse();
        return $response->setData($feeds);
    }
}

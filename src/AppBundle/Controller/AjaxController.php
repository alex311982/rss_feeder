<?php

namespace AppBundle\Controller;

use AppBundle\Exception\FeederException;
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

    public function indexAction(Request $request): Response
    {
        try {
            $data = $this->feedHandler->getFeedsByOffset($request->query->get('offset'));
            $count = count($data);
            $total = $this->feedHandler->getFeedsCount([
                'category_slug' => $request->query->get('category_slug')
            ]);
        } catch (FeederException $e) {
            $error = $e->getMessage();
        }
        $response = new JsonResponse();

        return $response->setData(compact('data', 'count', 'total', 'error'));
    }
}

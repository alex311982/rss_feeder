<?php

namespace AppBundle\Controller;

use AppBundle\Exception\FeederException;
use AppBundle\Handler\CategoryHandler;
use AppBundle\Handler\FeedHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation as DI;

class AjaxController extends Controller
{
    /**
     * @var $feedHandler FeedHandler
     *
     * @DI\Inject("feed.handler")
     */
    protected $feedHandler;

    /**
     * @var $categoryHandler CategoryHandler
     *
     * @DI\Inject("category.handler")
     */
    protected $categoryHandler;

    /**
     * @param Request $request
     * @return Response
     */
    public function feedsAction(Request $request): Response
    {
        $offset = $request->query->get('offset') ? : $this->getParameter('rss_feeder.offset');

        try {
            $data = $this->feedHandler->getFeedsByConditions($request->query->all(), $offset);
            $count = count($data);
            $total = $this->feedHandler->getFeedsCount($request->query->all());
        } catch (FeederException $e) {
            $error = $e->getMessage();
        }
        $response = new JsonResponse();

        return $response->setData(compact('data', 'count', 'total', 'error'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function categoriesAction(Request $request): Response
    {
        $data = [];

        try {
            $data = $this->categoryHandler->getCategories();

            foreach ($data as $key => $category) {
                $data[$key]['url'] = $this->generateUrl('category', array('slug' => $category['slug']));
            }

            $total = $count = count($data);
        } catch (FeederException $e) {
            $error = $e->getMessage();
        }
        $response = new JsonResponse();

        $data = array_values($data);

        return $response->setData(compact('data', 'count', 'total', 'error'));
    }
}

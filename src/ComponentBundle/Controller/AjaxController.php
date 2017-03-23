<?php

namespace ComponentBundle\Controller;

use ComponentBundle\Exception\ComponentException;
use ComponentBundle\Handler\CategoryHandler;
use ComponentBundle\Handler\NewsHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation as DI;

class AjaxController extends Controller
{
    /**
     * @var $newsHandler NewsHandler
     *
     * @DI\Inject("news.handler")
     */
    protected $newsHandler;

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
    public function newsAction(Request $request): Response
    {
        $offset = $request->query->get('offset') ? : $this->getParameter('component.news.offset');
        $request->query->remove('offset');

        try {
            $data = $this->newsHandler->getNewsByConditions($request->query->all(), $offset);
            $count = count($data);
            $total = $this->newsHandler->getNewsCount($request->query->all());
        } catch (ComponentException $e) {
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
        } catch (ComponentException $e) {
            $error = $e->getMessage();
        }
        $response = new JsonResponse();

        $data = array_values($data);

        return $response->setData(compact('data', 'count', 'total', 'error'));
    }
}

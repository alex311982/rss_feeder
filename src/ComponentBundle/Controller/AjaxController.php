<?php

namespace ComponentBundle\Controller;

use ComponentBundle\Components\Interfaces\ComponentInterface;
use ComponentBundle\Exception\ComponentException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    /**
     * @param Request $request
     * @param string $component
     * @return Response
     */
    public function indexAction(Request $request, string $component): Response
    {
        try {
            /** @var ComponentInterface $componentInst */
            $componentInst = $this->container->get(strtolower($component) . '.component');

            $componentResponse = $componentInst->getData($request->query->all());
            $data = $componentResponse->getData();
            $count = $componentResponse->getCount();
            $total = $componentResponse->getTotal();
        } catch (ComponentException $e) {
            $error = $e->getMessage();
        } catch (ServiceNotFoundException $e) {
            $error = $e->getMessage();
        } catch (\Exception $e) {
            $error = (string)$e;
        }

        $response = new JsonResponse();

        return $response->setData(compact('data', 'count', 'total', 'error'));
    }
}

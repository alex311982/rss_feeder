<?php

namespace ComponentBundle\Controller;

use ComponentBundle\Components\Interfaces\ComponentInterface;
use ComponentBundle\Exception\ComponentException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ComponentController extends Controller
{
    public function indexAction(string $component): Response
    {
        try {
            /** @var ComponentInterface $componentInst */
            $componentInst = $this->container->get(strtolower($component) . '.component');

            $data = $componentInst->render();
        } catch (ComponentException $e) {
            $data = $e->getMessage();
        } catch (ServiceNotFoundException $e) {
            $data = $e->getMessage();
        } catch (\Exception $e) {
            $data = 'Please catch me!';
        }

        return new Response($data);
    }
}

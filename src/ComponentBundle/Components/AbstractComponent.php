<?php

namespace ComponentBundle\Components;

use ComponentBundle\Components\Interfaces\ComponentInterface;
use ComponentBundle\Handler\Interfaces\HandlerInterfaces;
use ComponentBundle\Response\DataResponse;

abstract class AbstractComponent implements ComponentInterface
{
    protected $handler;

    public function setHandler(HandlerInterfaces $handler)
    {
        $this->handler = $handler;
    }

    public static function getName(): string
    {
        return static::$name;
    }

    public function getData(array $options): DataResponse
    {
        $handler = $this->getHandler();
        $handler->setOptions($options);

        return new DataResponse(
            $handler->getData(),
            $handler->getTotal()
        );
    }

    protected function getHandler(): HandlerInterfaces
    {
        return $this->handler;
    }
}

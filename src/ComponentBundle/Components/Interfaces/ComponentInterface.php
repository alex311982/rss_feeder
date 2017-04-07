<?php

namespace ComponentBundle\Components\Interfaces;

use ComponentBundle\Handler\Interfaces\HandlerInterfaces;
use ComponentBundle\Response\DataResponse;

interface ComponentInterface
{
    public function setHandler(HandlerInterfaces $handler);

    public function render() : string;

    public function getData(array $options): DataResponse;

    public static function getName() : string;
}

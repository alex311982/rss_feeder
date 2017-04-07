<?php

namespace ComponentBundle\Handler\Interfaces;

interface HandlerInterfaces
{
    public function getData(): array;

    public function getTotal(): int;

    public function setOptions(array $options);
}
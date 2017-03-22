<?php

namespace ComponentBundle\Handler;

/**
 * Interface CategoryHandlerInterface
 * @package ComponentBundle\Handler
 */
interface CategoryHandlerInterface
{
    /**
     * @param string $url
     * @param int $count
     *
     */
    public function getCategories();
}

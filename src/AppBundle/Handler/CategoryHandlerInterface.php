<?php

namespace AppBundle\Handler;

/**
 * Interface CategoryHandlerInterface
 * @package AppBundle\Handler
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

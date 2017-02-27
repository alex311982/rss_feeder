<?php

namespace AppBundle\Handler;

/**
 * Interface HandlerInterface
 * @package AppBundle\Handler
 */
interface HandlerInterface
{
    /**
     * @param string $url
     * @param int $count
     *
     */
    public function getLastFeeds(string $url, int $count = 10);
}

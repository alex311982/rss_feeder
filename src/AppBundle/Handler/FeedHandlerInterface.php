<?php

namespace AppBundle\Handler;

/**
 * Interface FeedHandlerInterface
 * @package AppBundle\Handler
 */
interface FeedHandlerInterface
{
    /**
     * @param string $url
     * @param int $count
     *
     */
    public function getLastFeeds(string $url, int $count);
}

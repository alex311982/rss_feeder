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

    /**
     * @param int $offset
     * @return array
     */
    public function getFeedsByOffset(int $offset): array;

    /**
     * @param array $criteria
     * @return mixed
     */
    public function getFeedsCount(array $criteria = []): int;
}

<?php

namespace ComponentBundle\Handler;

/**
 * Interface NewsHandlerInterface
 * @package ComponentBundle\Handler
 */
interface NewsHandlerInterface
{
    /**
     * @param array $condtitions
     * @param int $offset
     * @return array
     */
    public function getNewsByConditions(array $condtitions = [], int $offset): array;

    /**
     * @param array $criteria
     * @return mixed
     */
    public function getNewsCount(array $criteria = []): int;
}

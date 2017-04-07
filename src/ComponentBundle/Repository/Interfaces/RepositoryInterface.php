<?php

namespace ComponentBundle\Repository\Interfaces;

interface RepositoryInterface
{
    public function truncate();

    public function findTotalByConditions(array $criteria = []): int;
}

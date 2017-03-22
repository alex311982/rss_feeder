<?php

namespace ComponentBundle\Handler;

use ComponentBundle\Entity\NewsEntity;
use ComponentBundle\Exception\ComponentException;
use ComponentBundle\Repository\NewsEntityRepository;
use Doctrine\ORM\EntityManager;

class NewsHandler implements NewsHandlerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var int
     */
    protected $frontLimit;
    /**
     * @var array
     */
    protected $news;

    public function __construct(
        EntityManager $em,
        int $frontLimit,
        int $curlLimit
    )
    {
        $this->em = $em;
        $this->frontLimit = $frontLimit;
        $this->news = [];
    }

    /**
     * @param array $condtitions
     * @return array
     * @throws ComponentException
     * @internal param int $offset
     */
    public function getNewsByConditions(array $condtitions = [], int $offset): array
    {
        if ($this->news) {
            return $this->news;
        }

        /** @var NewsEntityRepository $newsRepository */
        $newsRepository = $this->getRepository('ComponentBundle:NewsEntity');
        try {
            $news = $newsRepository->findWithLimitAndOffset($condtitions, $this->frontLimit, $offset);
        } catch (\Exception $e) {
            throw new ComponentException(ComponentException::ORM_ERROR_MSG);
        }

        /** @var NewsEntity $newsItem */
        foreach($news as $newsItem) {
            array_push($this->news, $newsItem->toArray());
        }

        return $this->news;
    }

    public function getNewsCount(array $criteria = []): int
    {
        return $this->getRepository('ComponentBundle:NewsEntity')->findCount($criteria);
    }

    /**
     * @param string $metaName
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository(string $metaName):\Doctrine\ORM\EntityRepository
    {
        return $this->em->getRepository($metaName);
    }
}

<?php

namespace ComponentBundle\Handler;

use ComponentBundle\Entity\ParserNewsEntity;
use ComponentBundle\Exception\ComponentException;
use ComponentBundle\Handler\Interfaces\HandlerInterfaces;
use ComponentBundle\Repository\Interfaces\RepositoryInterface;
use ComponentBundle\Repository\ParserNewsEntityRepository;
use Doctrine\ORM\EntityManager;

class NewsHandler implements HandlerInterfaces
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
     * @var int
     */
    protected $offset;

    protected $options;

    public function __construct(
        EntityManager $em,
        int $frontLimit,
        int $offset
    ) {
        $this->em = $em;
        $this->frontLimit = $frontLimit;
        $this->setOffset($offset);
        $this->options = [];
    }

    public function setOptions(array $options)
    {
        $offset = isset($options['offset']) ? $options['offset'] : $this->offset;
        unset($options['offset']);
        $this->options = $options;
        $this->setOffset($offset);
    }

    /**
     * @return array
     * @throws ComponentException
     * @internal param int $offset
     */
    public function getData(): array
    {
        $newsItems = [];

        /** @var ParserNewsEntityRepository $newsRepository */
        $newsRepository = $this->getRepository('ComponentBundle:NewsEntity');

        try {
            $news = $newsRepository->findBy($this->options, ['pubDate' => 'DESC'], $this->frontLimit, $this->offset);
        } catch (\Exception $e) {
            throw new ComponentException(ComponentException::formatMsg(
                ['%component_name%' => 'news'],
                ComponentException::ORM_ERROR_MSG
                )
            );
        }

        /** @var ParserNewsEntity $newsItem */
        foreach($news as $newsItem) {
            array_push($newsItems, $newsItem->toArray());
        }

        return $newsItems;
    }

    public function getTotal(): int
    {
        /** @var RepositoryInterface $newsRepository */
        $newsRepository = $this->getRepository('ComponentBundle:NewsEntity');

        return $newsRepository->findTotalByConditions($this->options);
    }

    /**
     * @param int $offset
     */
    protected function setOffset(int $offset)
    {
        $this->offset = $offset;
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

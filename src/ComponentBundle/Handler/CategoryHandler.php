<?php

namespace ComponentBundle\Handler;

use ComponentBundle\Entity\NewsEntity;
use ComponentBundle\Exception\ComponentException;
use ComponentBundle\Repository\NewsEntityRepository;
use Doctrine\ORM\EntityManager;

class CategoryHandler implements CategoryHandlerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var array
     */
    protected $categories;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->categories = [];
    }

    public function getCategories(): array
    {
        if ($this->categories) {
            return $this->categories;
        }

        /** @var NewsEntityRepository $newsRepository */
        $newsRepository = $this->getRepository('ComponentBundle:NewsEntity');

        try {
            $news = $newsRepository->findAll();
        } catch (\Exception $e) {
            throw new ComponentException(ComponentException::ORM_ERROR_MSG);
        }

        /** @var NewsEntity $newsItem */
        foreach ($news as $newsItem) {
            $this->categories[$newsItem->getSlug()] = [
                'name' => $newsItem->getCategory(),
                'slug' => $newsItem->getSlug(),
            ];
        }

        return $this->categories;
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

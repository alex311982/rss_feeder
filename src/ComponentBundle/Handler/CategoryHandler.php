<?php

namespace ComponentBundle\Handler;

use ComponentBundle\Entity\CategoryEntity;
use ComponentBundle\Exception\ComponentException;
use ComponentBundle\Handler\Interfaces\HandlerInterfaces;
use ComponentBundle\Repository\ParserCategoryEntityRepository;
use Doctrine\ORM\EntityManager;

class CategoryHandler implements HandlerInterfaces
{
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var array
     */
    protected $categories;

    protected $options;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->categories = [];
        $this->options = [];
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getData(): array
    {
        if ($this->categories) {
            return $this->categories;
        }

        /** @var ParserCategoryEntityRepository $categoryRepository */
        $categoryRepository = $this->getRepository('ComponentBundle:CategoryEntity');

        try {
            $this->categories = $categoryRepository->findAll();
        } catch (\Exception $e) {
            throw new ComponentException(ComponentException::ORM_ERROR_MSG);
        }

        /** @var CategoryEntity $categoryItem */
        foreach($this->categories as $key => $categoryItem) {
            $this->categories[$key] = $categoryItem->toArray();
        }

        return $this->categories;
    }

    public function getTotal(): int
    {
        /** @var ParserCategoryEntityRepository $categoryRepository */
        $categoryRepository = $this->getRepository('ComponentBundle:CategoryEntity');

        return $categoryRepository->findTotalByConditions($this->options);
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

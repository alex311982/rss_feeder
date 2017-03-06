<?php

namespace AppBundle\Handler;

use AppBundle\Entity\FeedEntity;
use AppBundle\Entity\MediaEntity;
use AppBundle\Exception\FeederException;
use AppBundle\Repository\FeedEntityRepository;
use Doctrine\ORM\EntityManager;
use Exception;
use FeedIo\Adapter\NotFoundException;
use FeedIo\Adapter\ServerErrorException;
use FeedIo\Feed\Item;
use FeedIo\FeedInterface;
use FeedIo\FeedIo;

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

        /** @var FeedEntityRepository $feedRepository */
        $feedRepository = $this->getRepository('AppBundle:FeedEntity');

        try {
            $feeds = $feedRepository->findAll();
        } catch (\Exception $e) {
            throw new FeederException(FeederException::ORM_ERROR_MSG);
        }

        /** @var FeedEntity $feed */
        foreach ($feeds as $feed) {
            $this->categories[$feed->getSlug()] = [
                'name' => $feed->getCategory(),
                'slug' => $feed->getSlug(),
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

<?php

namespace AppBundle\Handler;

use AppBundle\Entity\FeedEntity;
use AppBundle\Entity\MediaEntity;
use Doctrine\ORM\EntityManager;
use FeedIo\Feed;
use FeedIo\Feed\Item;
use FeedIo\FeedIo;

class FeedHandler implements HandlerInterface
{
    /**
     * @var FeedIo
     */
    private $feedParser;
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(
        FeedIo $feedParser,
        EntityManager $em
    )
    {
        $this->feedParser = $feedParser;
        $this->em = $em;
    }

    /**
     * @param string $url
     * @param int $count
     *
     */
    public function getLastFeeds(string $url, int $count = 10)
    {
        $feed = $this->feedParser->read($url)->getFeed();
        foreach($feed as $i => $item) {
            $feedEntity = $this->feedToEntityTransformer($item);
            if ($item->hasMedia()) {
                $mediaEntity = $this->mediaToEntityTransformer($item);
                $this->em->persist($mediaEntity);
                $feedEntity->setMedia($mediaEntity);
            }
            $this->em->persist($feedEntity);
            if ($count === $i+1 )
                break;
        }

        $this->em->flush();
    }

    protected function feedToEntityTransformer(Item $feed): FeedEntity
    {
        $category = $feed->getCategories()->current()->getLabel() ? : null;

        return new FeedEntity(
            $feed->getPublicId(),
            $category,
            $feed->getTitle(),
            $feed->getDescription(),
            $feed->getLastModified(),
            $feed->getLink()
        );
    }

    protected function mediaToEntityTransformer(Item $item): MediaEntity
    {
        $media = $item->getMedias()->current();

        return new MediaEntity(
            $media->getType(),
            $media->getUrl(),
            $media->getLength()
        );
    }
}

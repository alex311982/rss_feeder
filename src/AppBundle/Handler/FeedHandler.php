<?php

namespace AppBundle\Handler;

use AppBundle\Entity\FeedEntity;
use AppBundle\Entity\MediaEntity;
use AppBundle\Exception\FeederException;
use Doctrine\ORM\EntityManager;
use Exception;
use FeedIo\Adapter\NotFoundException;
use FeedIo\Adapter\ServerErrorException;
use FeedIo\Feed;
use FeedIo\Feed\Item;
use FeedIo\FeedInterface;
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
     * @throws Exception
     */
    public function getLastFeeds(string $url, int $count)
    {
        try {
            $feed = $this->getFeeds($url);
        } catch (Exception $e) {
            throw new FeederException($e->getMessage());
        }

        $count > 0  ? : $count = 50;
        
        $this->em->getRepository('AppBundle:FeedEntity')->truncate();
        $this->em->getRepository('AppBundle:MediaEntity')->truncate();

        foreach($feed as $i => $item) {
            $feedEntity = $this->feedToEntityTransformer($item);
            if ($item->hasMedia()) {
                $mediaEntity = $this->mediaToEntityTransformer($item);
                $this->em->persist($mediaEntity);
                $feedEntity->setMedia($mediaEntity);
            }
            $this->em->persist($feedEntity);

            if ($count === $i+1 ) {
                break;
            }
        }

        $this->em->flush();
    }

    protected function getFeeds(string $url): FeedInterface
    {
        try {
            return $this->feedParser->read($url)->getFeed();
        } catch (NotFoundException $e) {
            throw new Exception('Server is not found');
        } catch (ServerErrorException $e) {
            throw new Exception('Server error');
        }
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

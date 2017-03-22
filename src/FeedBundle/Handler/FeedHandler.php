<?php

namespace FeedBundle\Handler;

use FeedBundle\Entity\FeedEntity;
use FeedBundle\Entity\MediaEntity;
use FeedBundle\Exception\FeederException;
use FeedBundle\Repository\FeedEntityRepository;
use Doctrine\ORM\EntityManager;
use FeedIo\Adapter\NotFoundException;
use FeedIo\Adapter\ServerErrorException;
use FeedIo\Feed\Item;
use FeedIo\FeedInterface;
use FeedIo\FeedIo;

class FeedHandler implements FeedHandlerInterface
{
    /**
     * @var FeedIo
     */
    protected $feedParser;
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
    protected $curlLimit;
    /**
     * @var array
     */
    protected $feeds;

    public function __construct(
        FeedIo $feedParser,
        EntityManager $em,
        int $frontLimit,
        int $curlLimit
    )
    {
        $this->feedParser = $feedParser;
        $this->em = $em;
        $this->frontLimit = $frontLimit;
        $this->curlLimit = $curlLimit;
        $this->feeds = [];
    }

    /**
     * Curl request for RSS
     *
     * @param string $url
     * @param int $count
     * @throws FeederException
     */
    public function getLastFeeds(string $url, int $count)
    {
        $feed = $this->process($url);
        $count > 0  ? : $count = $this->curlLimit;
        $this->getRepository('FeedBundle:NewsEntity')->truncate();
        $this->getRepository('FeedBundle:MediaEntity')->truncate();

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

    /**
     * @param string $url
     * @return FeedInterface
     * @throws FeederException
     */
    protected function process(string $url): FeedInterface
    {
        try {
            return $this->feedParser->read($url)->getFeed();
        } catch (NotFoundException $e) {
            throw new FeederException(FeederException::SERVER_NOT_FOUND_ERROR_MSG);
        } catch (ServerErrorException $e) {
            throw new FeederException(FeederException::SERVER_ERROR_MSG);
        }
    }

    /**
     * @param Item $feed
     * @return FeedEntity
     */
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

    /**
     * @param Item $item
     * @return MediaEntity
     */
    protected function mediaToEntityTransformer(Item $item): MediaEntity
    {
        $media = $item->getMedias()->current();

        return new MediaEntity(
            $media->getType(),
            $media->getUrl(),
            $media->getLength()
        );
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
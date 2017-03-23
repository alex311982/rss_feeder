<?php

namespace FeedBundle\Handler;

use ComponentBundle\Entity\MediaEntity;
use ComponentBundle\Entity\NewsEntity;
use FeedBundle\Exception\FeederException;
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
    protected $curlLimit;

    public function __construct(
        FeedIo $feedParser,
        EntityManager $em,
        int $curlLimit
    )
    {
        $this->feedParser = $feedParser;
        $this->em = $em;
        $this->curlLimit = $curlLimit;
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
        $this->getRepository('ComponentBundle:NewsEntity')->truncate();
        $this->getRepository('ComponentBundle:MediaEntity')->truncate();

        foreach($feed as $i => $item) {
            $newsItem = $this->feedToEntityTransformer($item);
            if ($item->hasMedia()) {
                $mediaEntity = $this->mediaToEntityTransformer($item);
                $this->em->persist($mediaEntity);
                $newsItem->setMedia($mediaEntity);
            }
            $this->em->persist($newsItem);

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
     * @return NewsEntity
     */
    protected function feedToEntityTransformer(Item $feed): NewsEntity
    {
        $category = $feed->getCategories()->current()->getLabel() ? : null;

        return new NewsEntity(
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

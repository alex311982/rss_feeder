<?php

namespace AppBundle\Handler;

use AppBundle\Entity\FeedEntity;
use Doctrine\ORM\EntityManager;
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
        //TODO - перенести в репозиторий
        $this->em->createQuery('DELETE FROM AppBundle:FeedEntity')->execute();

        $feed = $this->feedParser->read($url, new FeedEntity)->getFeed();

        $this->em->persist($feed);

        foreach($feed as $i => $item) {
            $this->em->persist($item);

            if ($count === $i+1 )
                break;
        }

        $this->em->flush();
    }
}

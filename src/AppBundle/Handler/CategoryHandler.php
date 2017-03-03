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
}

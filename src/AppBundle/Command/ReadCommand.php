<?php
/*
 * This file is part of the feed-io package.
 *
 * (c) Alexandre Debril <alex.debril@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command;

use FeedIo\Factory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReadCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('read')
            ->setDescription('reads a feed')
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
                'Please provide the feed\' URL'
            )
            ->addOption('count', 'c', InputOption::VALUE_OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $limit = $this->getLimit($input);
        $feedHandler = $this->getContainer()->get('feed.handler');

        $feedHandler->getLastFeeds($url, $limit);
    }

    /**
     * @param string $url
     * @return \FeedIo\FeedInterface
     */
    public function readFeed($url)
    {
        $feedIo = Factory::create()->getFeedIo();

        return $feedIo->read($url)->getFeed();
    }

    /**
     * @param InputInterface $input
     * @return int|null
     */
    public function getLimit(InputInterface $input)
    {
        if ( $input->hasOption('count') ) {
            return intval($input->getOption('count'));
        }

        return null;
    }
}


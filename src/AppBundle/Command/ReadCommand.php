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

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReadCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('read:feeds')
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
     * @param InputInterface $input
     * @return int|null
     */
    protected function getLimit(InputInterface $input)
    {
        if ( $input->hasOption('count') ) {
            return intval($input->getOption('count'));
        }

        return null;
    }
}

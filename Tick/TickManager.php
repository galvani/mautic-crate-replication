<?php


namespace MauticPlugin\CrateReplicationBundle\Tick;


use MauticPlugin\CrateReplicationBundle\Traits\Iterator;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class TickManager implements \Iterator, \Countable
{
    use Iterator;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->eventDispatcher = new EventDispatcher();
        $this->logger = $logger;
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher(): EventDispatcher
    {
        return $this->eventDispatcher;
    }

    /**
     * @param TickInterface $value
     */
    public function register(TickInterface $value)
    {
        foreach ($value->getSubscribedEntities() as $entity) {
            $value->setLogger($this->logger);
            $this->eventDispatcher->addListener(
                $entity,
                [$value, 'parse']
            );
            $this->values[$entity][$value->getName()] = $value;
        }
    }




}
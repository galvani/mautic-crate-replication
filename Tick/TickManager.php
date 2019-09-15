<?php


namespace MauticPlugin\CrateReplicationBundle\Tick;


use MauticPlugin\CrateReplicationBundle\Crate\EntityManagerFactory;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;

class TickManager implements \Iterator, \Countable
{
    private $position = 0;

    private $entityMap = [];
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    /**
     * @var Logger
     */
    private $logger;

    public function setLogger(Logger $logger) {
        $this->logger = $logger;
    }

    public function __construct($array = array(), $flags = 0)
    {
        $this->eventDispatcher = new EventDispatcher();

        foreach ($array as $element) {
            $this->append($element);
        }
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
            $this->eventDispatcher->addListener(
                $entity,
                [$value, 'parse']
            );
            $this->entityMap[$entity][$value->getName()] = $value;
        }
    }

    /** @inheritDoc */
    public function current()
    {
        return $this->entityMap[$this->position] ?? null;
    }

    /** @inheritDoc */
    public function next()
    {
        if (isset($this->entityMap[$this->position+1])) {
            $this->position++;
            return $this->entityMap[$this->position];
        };

        return null;
    }

    /** @inheritDoc */
    public function key()
    {
        return $this->position;
    }

    /** @inheritDoc */
    public function valid()
    {
        return isset($this->entityMap[$this->position]);
    }

    /** @inheritDoc */
    public function rewind()
    {
        $this->position = 0;
    }

    /** @inheritDoc */
    public function count()
    {
        return count($this->entityMap);
    }


}
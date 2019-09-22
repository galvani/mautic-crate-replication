<?php


namespace MauticPlugin\CrateReplicationBundle\Tick;

use Doctrine\ORM\EntityManager;
use MauticPlugin\CrateReplicationBundle\Crate\EntityManagerFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class AbstractTick implements EventSubscriberInterface, TickInterface
{
    /**
     * @var EntityManagerFactory
     */
    private $entityManagerFactory;

    /**
     * @var ?EntityManager
     */
    private $entityManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param EntityManagerFactory $entityManagerFactory
     */
    public function __construct(EntityManagerFactory $entityManagerFactory)
    {
        $this->entityManagerFactory = $entityManagerFactory;
    }

    /**
     * @return EntityManager
     * @throws \MauticPlugin\CrateReplicationBundle\Exception\ConfigurationException
     */
    public function getEntityManager(): EntityManager
    {
        if (null === $this->entityManager) {
            $this->entityManager = $this->entityManagerFactory->getEntityManager();
        }

        return $this->entityManager;
    }


    /** @inheritDoc */
    public static function getSubscribedEvents()
    {
        $events = [];
        foreach (self::getSubscribedEntities() as $entity) {
            $events[$entity] = 'parse';
        }
        return $events;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return AbstractTick
     */
    public function setLogger(LoggerInterface $logger): TickInterface
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
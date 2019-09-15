<?php

namespace MauticPlugin\CrateReplicationBundle\Events;

class DoctrineLifecycleEvent extends \Symfony\Component\EventDispatcher\Event
{
    /**
     * @var \Doctrine\ORM\Event\LifecycleEventArgs
     */
    private $lifecycleEventArgs;

    public function __construct(\Doctrine\ORM\Event\LifecycleEventArgs $lifecycleEventArgs)

    {
        $this->lifecycleEventArgs = $lifecycleEventArgs;
    }

    /**
     * @return \Doctrine\ORM\Event\LifecycleEventArgs
     */
    public function getLifecycleEventArgs(): \Doctrine\ORM\Event\LifecycleEventArgs
    {
        return $this->lifecycleEventArgs;
    }
}
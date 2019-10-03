<?php


namespace MauticPlugin\CrateReplicationBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Mautic\CacheBundle\Cache\Adapter\RedisTagAwareAdapter;
use MauticPlugin\CrateReplicationBundle\Config\Settings;
use MauticPlugin\CrateReplicationBundle\Events\DoctrineLifecycleEvent;
use MauticPlugin\CrateReplicationBundle\Tick\TickManager;

class DoctrineListener implements EventSubscriber
{
    /**
     * @var RedisTagAwareAdapter
     */
    private $cache;
    /**
     * @var Settings
     */
    private $settings;
    /**
     * @var TickManager
     */
    private $tickManager;

    /**
     * DoctrineListener constructor.
     *
     * @param RedisTagAwareAdapter $cache
     * @param Settings             $settings
     * @param TickManager          $tickProvider
     */
    public function __construct(RedisTagAwareAdapter $cache, Settings $settings, TickManager $tickProvider)
    {
        $this->cache       = $cache;
        $this->settings    = $settings;
        $this->tickManager = $tickProvider;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist,
            Events::postUpdate,
        );
    }
    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->index($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->index($args);

        
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function index(LifecycleEventArgs $args): void
    {
        var_dump($this->tickManager->getEventDispatcher()->getListeners());
        $this->tickManager->getEventDispatcher()->dispatch(
            get_class($args->getObject()),
            new DoctrineLifecycleEvent($args)
        );
    }
}
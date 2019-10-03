<?php


namespace MauticPlugin\CrateReplicationBundle\Messenger;


use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

class QueueManager
{
    public function __construct(TagAwareAdapterInterface $cache)
    {

    }
}
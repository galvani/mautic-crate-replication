<?php


namespace MauticPlugin\CrateReplicationBundle\Queue;


use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

class QueueManager
{
    public function __construct(TagAwareAdapterInterface $cache)
    {

    }
}
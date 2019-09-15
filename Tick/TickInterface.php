<?php


namespace MauticPlugin\CrateReplicationBundle\Tick;


use MauticPlugin\CrateReplicationBundle\Events\DoctrineLifecycleEvent;

interface TickInterface
{
    public function getName(): string;
    public static function getSubscribedEntities(): array;
    public function parse(DoctrineLifecycleEvent $object): void;
}
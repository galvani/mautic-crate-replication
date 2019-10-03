<?php


namespace MauticPlugin\CrateReplicationBundle\Tick;


use MauticPlugin\CrateReplicationBundle\Crate\Entity\CrateEntity;
use Psr\Log\LoggerInterface;

interface TickInterface
{
    public function getName(): string;

    public static function getSubscribedEntities(): array;

    public function parse($object): CrateEntity;

    public function setLogger(LoggerInterface $logger): self;
}
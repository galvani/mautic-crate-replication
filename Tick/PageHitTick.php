<?php


namespace MauticPlugin\CrateReplicationBundle\Tick;

use Mautic\PageBundle\Entity\Hit;
use MauticPlugin\CrateReplicationBundle\Crate\Entity\CrateEntity;
use MauticPlugin\CrateReplicationBundle\Crate\Entity\PageHit;
use MauticPlugin\CrateReplicationBundle\Events\DoctrineLifecycleEvent;

class PageHitTick extends AbstractTick
{
    public function getName(): string
    {
        return get_class($this);
    }

    /** @inheritDoc */
    public static function getSubscribedEntities(): array
    {
        return [Hit::class];
    }

    public function parse($object): CrateEntity
    {
        var_dump($event);
        $hit = new PageHit();
        $hit->id = 1;
        $hit->leadId = 1;
        $hit->hitUrl = 'http://www.google.com';

        $this->getEntityManager()->persist($hit);
        $this->getEntityManager()->flush();

        $this->getEntityManager()->getConnection()->commit();

        var_dump($this->getEntityManager()->getClassMetadata(PageHit::class));
        var_dump($event);
        // TODO: Implement parse() method.
    }

    //public function get
}
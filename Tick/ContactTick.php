<?php


namespace MauticPlugin\CrateReplicationBundle\Tick;

use Mautic\LeadBundle\Entity\Lead;
use MauticPlugin\CrateReplicationBundle\Crate\Entity\CrateEntity;
use MauticPlugin\CrateReplicationBundle\Crate\EntityManagerFactory;
use MauticPlugin\CrateReplicationBundle\Events\DoctrineLifecycleEvent;
use MauticPlugin\CrateReplicationBundle\Exception\InvalidArgumentException;
use MauticPlugin\CrateReplicationBundle\Tick\Factory\ContactFactory;

class ContactTick extends AbstractTick
{
    /**
     * @var ContactFactory
     */
    private $factory;

    public function __construct(EntityManagerFactory $entityManagerFactory, ContactFactory $factory)
    {
        parent::__construct($entityManagerFactory);
        $this->factory = $factory;
    }

    /** @inheritDoc */
    public static function getSubscribedEntities(): array
    {
        return [Lead::class];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Contact';
    }


    public function parse($object): CrateEntity
    {
        /** @var Lead $object */
        if (!$object instanceof Lead) {
            throw new InvalidArgumentException("This tick expects argument of type " . Lead::class);
        }
        return $this->factory->create($object);
    }
}
<?php

namespace MauticPlugin\CrateReplicationBundle\Tick\Factory;

use Mautic\LeadBundle\Entity\Lead;
use MauticPlugin\CrateReplicationBundle\Crate\Entity\Contact;

class ContactFactory
{
    public function create(Lead $entity): Contact {
        $contact = new Contact();
        $contact->setId($entity->getId());
        $contact->setEmail($entity->getEmail());
        var_dump($contact);
        return $contact;
    }
}
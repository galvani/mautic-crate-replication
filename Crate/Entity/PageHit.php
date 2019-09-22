<?php


namespace MauticPlugin\CrateReplicationBundle\Crate\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity()
 * @ORM\Table(name="pagehits")
 */
class PageHit
{
    /**
     * @Id
     * @Column(type="int",unique=true)
     */
    public $id;

    /**
     * @Column(type="integer",nullable=false)
     */
    public $leadId;

    /**
     * @Column(type="text",nullable=false)
     */
    public $hitUrl;


}
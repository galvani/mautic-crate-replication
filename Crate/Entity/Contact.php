<?php


namespace MauticPlugin\CrateReplicationBundle\Crate\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity()
 * @ORM\Table(name="leads")
 */
class Contact extends CrateEntity
{
    /**
     * @Id
     * @Column(type="int",unique=true)
     */
    public $id;

    /**
     * @Column(type="string")
     */
    public $email;

    /**
     * @Colum(type="string");
     */
    public $lastName;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Contact
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }
}
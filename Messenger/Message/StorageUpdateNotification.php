<?php


namespace MauticPlugin\CrateReplicationBundle\Messenger\Message;


class StorageUpdateNotification
{
    private $entity;
    private $action;
    private $tick;

    public function __construct($tick, $action, $entity)
    {
        $this->tick = $tick;
        $this->action = $action;
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getTick()
    {
        return $this->tick;
    }

    /**
     * @param mixed $tick
     */
    public function setTick($tick): void
    {
        $this->tick = $tick;
    }


}
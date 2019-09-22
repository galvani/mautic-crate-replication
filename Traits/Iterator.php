<?php

namespace MauticPlugin\CrateReplicationBundle\Traits;

trait Iterator
{
    /**
     * @var int
     */
    private $position = 0;

    /**
     * @var array
     */
    private $values = [];

    /** @inheritDoc */
    public function current()
    {
        return $this->values[$this->position] ?? null;
    }

    /** @inheritDoc */
    public function next()
    {
        if (isset($this->values[$this->position+1])) {
            $this->position++;
            return $this->values[$this->position];
        };

        return null;
    }

    /** @inheritDoc */
    public function key()
    {
        return $this->position;
    }

    /** @inheritDoc */
    public function valid()
    {
        return isset($this->values[$this->position]);
    }

    /** @inheritDoc */
    public function rewind()
    {
        $this->position = 0;
    }

    /** @inheritDoc */
    public function count()
    {
        return count($this->values);
    }
}
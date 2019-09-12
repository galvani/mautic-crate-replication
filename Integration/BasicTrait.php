<?php

declare(strict_types=1);

namespace MauticPlugin\CrateReplicationBundle\Integration;

trait BasicTrait
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return self::BUNDLE_NAME;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->getName();
    }
}

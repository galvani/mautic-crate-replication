<?php


namespace MauticPlugin\CrateReplicationBundle\Integration;

use MauticPlugin\CrateReplicationBundle\CrateReplicationBundle;
use MauticPlugin\IntegrationsBundle\Integration\BasicIntegration;
use MauticPlugin\IntegrationsBundle\Integration\Interfaces\BasicInterface;
use MauticPlugin\IntegrationsBundle\Integration\Interfaces\IntegrationInterface;

class CrateReplicationIntegration extends BasicIntegration implements BasicInterface, IntegrationInterface
{
    use BasicTrait;

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'plugins/CrateReplicationBundle/Assets/img/logo.png';
    }

    public function getName(): string
    {
        return CrateReplicationBundle::BUNDLE_NAME;
    }

    public function getDisplayName(): string
    {
        return CrateReplicationBundle::BUNDLE_DISPLAY_NAME;
    }
}

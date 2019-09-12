<?php

declare(strict_types=1);

namespace MauticPlugin\CrateReplicationBundle\Integration;

use Mautic\PluginBundle\Entity\Integration;
use MauticPlugin\CrateReplicationBundle\CrateReplicationBundle;
use MauticPlugin\CrateReplicationBundle\Form\Type\ConfigFormType;
use MauticPlugin\IntegrationsBundle\Integration\ConfigurationTrait;
use MauticPlugin\IntegrationsBundle\Integration\DefaultConfigFormTrait;
use MauticPlugin\IntegrationsBundle\Integration\Interfaces\ConfigFormFeaturesInterface;
use MauticPlugin\IntegrationsBundle\Integration\Interfaces\ConfigFormInterface;

class ConfigProvider implements
    ConfigFormInterface,
    ConfigFormFeaturesInterface
{
    use BasicTrait;
    use ConfigurationTrait;
    use DefaultConfigFormTrait;


    /**
     * @return array
     */
    public function getSupportedFeatures(): array
    {
        return [];
    }

    public function getName(): string
    {
        return CrateReplicationBundle::BUNDLE_NAME;
    }

    public function getConfigFormContentTemplate(): ?string
    {
        return 'CrateReplicationBundle:Config:config.html.php';
    }

    public function getConfigFormName(): ?string
    {
        return ConfigFormType::class;
    }
}

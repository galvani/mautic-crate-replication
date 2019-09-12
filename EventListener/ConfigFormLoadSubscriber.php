<?php

declare(strict_types=1);

namespace MauticPlugin\CrateReplicationBundle\EventListener;

use MauticPlugin\IntegrationsBundle\Event\FormLoadEvent;
use MauticPlugin\IntegrationsBundle\IntegrationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConfigFormLoadSubscriber implements EventSubscriberInterface
{
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            IntegrationEvents::INTEGRATION_CONFIG_FORM_LOAD => ['onConfigFormLoad', 0],
        ];
    }

    /**
     * @param FormLoadEvent $event
     */
    public function onConfigFormLoad(FormLoadEvent $event): void
    {

    }
}

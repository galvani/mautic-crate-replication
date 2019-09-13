<?php

namespace MauticPlugin\CrateReplicationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TickPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices     = $container->findTaggedServiceIds('crate_replication.tick');
        $integrationsHelper = $container->findDefinition('mautic.integration.crate_replication.tick_provider');

        foreach ($taggedServices as $id => $tags) {
            $integrationsHelper->addMethodCall('add', [new Reference($id)]);
        }
    }
}
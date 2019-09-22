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
        if (!$container->has('mautic.crate_replication.tick_manager')) {
            return;
        }

        $taggedServices     = $container->findTaggedServiceIds('crate_replication.tick');
        $tickManager = $container->findDefinition('mautic.crate_replication.tick_manager');

        foreach ($taggedServices as $id => $tags) {
                $tickManager->addMethodCall('register', [new Reference($id)]);
        }
    }
}
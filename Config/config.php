<?php

declare(strict_types=1);

/*
 * @copyright   2018 Mautic Inc. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://www.mautic.com
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

return [
    'name'        => 'Galvani CrateIO Replication engine',
    'description' => 'Enables CrateIO Replication for selected segment filters',
    'version'     => '2.0',
    'author'      => 'Mautic',
    'services'    => [
        'events'       => [
            'mautic.integration.crate_replication.subscriber.config_form_load' => [
                'class'     => \MauticPlugin\CrateReplicationBundle\EventListener\ConfigFormLoadSubscriber::class,
                'arguments' => [],
            ],
        ],
        'validators' => [],
        'forms'        => [
            'mautic.integration.crate_replication.form.config' => [
                'class'     => \MauticPlugin\CrateReplicationBundle\Form\Type\ConfigFormType::class,
                'arguments' => [
                    'mautic.integrations.helper'
                ],
            ],
        ],
        'helpers'      => [
        ],
        'other'        => [
            'mautic.integration.crate_replication.tick_provider' => [
                'class' => \MauticPlugin\CrateReplicationBundle\Tick\TickProvider::class,
            ],
            'mautic.integration.crate_replication.tick.page_hits' => [
                'class' => \MauticPlugin\CrateReplicationBundle\Tick\PageHitTick::class,
                'tag'   => 'crate_replication.tick'
            ],
        ],
        'models'       => [
        ],
        'integrations' => [
            'mautic.integration.crate_replication'      => [
                'class'     => \MauticPlugin\CrateReplicationBundle\Integration\CrateReplicationIntegration::class,
                'tags'      => [
                    'mautic.basic_integration'
                ],
            ],
            'mautic.integration.crate_replication.config' => [
                'class'     => \MauticPlugin\CrateReplicationBundle\Integration\ConfigProvider::class,
                'tag'       => 'mautic.config_integration',
                'arguments' => [],
            ],
        ],
    ],
    'routes'      => [
        'main'   => [
        ],
        'public' => [
        ],
        'api'    => [
        ],
    ],
    'menu'        => [
    ],
    'parameters'  => [
    ],
];

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
            'mautic.crate_replication.subscriber.config_form_load' => [
                'class'     => \MauticPlugin\CrateReplicationBundle\EventListener\ConfigFormLoadSubscriber::class,
                'arguments' => [],
            ],
        ],
        'validators'   => [],
        'forms'        => [
            'mautic.crate_replication.form.config' => [
                'class'     => \MauticPlugin\CrateReplicationBundle\Form\Type\ConfigFormType::class,
                'arguments' => [
                    'mautic.integrations.helper'
                ],
            ],
        ],
        'helpers'      => [
        ],
        'other'        => [
            'mautic.crate_replication.tick_manager'           => [
                'class' => \MauticPlugin\CrateReplicationBundle\Tick\TickManager::class,
                'calls' => [
                    [
                        'method'    => 'setLogger',
                        'arguments' => ['@logger']
                    ],[
                        'method'    => 'setEntityManager',
                        'arguments' => ['@mautic.crate_replication.factory.entity_manager']
                    ]
                ],
                'arguments' => [
                    '@logger'
                ]
            ],
            'mautic.crate_replication.factory.contact'         => [
                'class'     => \MauticPlugin\CrateReplicationBundle\Tick\Factory\ContactFactory::class
            ],

            'mautic.crate_replication.tick.page_hit'         => [
                'class'     => \MauticPlugin\CrateReplicationBundle\Tick\PageHitTick::class,
                'tag'       => 'crate_replication.tick',
                'arguments' => ['@mautic.crate_replication.factory.entity_manager']
            ],
            'mautic.crate_replication.tick.contact'         => [
                'class'     => \MauticPlugin\CrateReplicationBundle\Tick\ContactTick::class,
                'tag'       => 'crate_replication.tick',
                'arguments' => ['@mautic.crate_replication.factory.entity_manager','@mautic.crate_replication.factory.contact']
            ],
            'mautic.crate_replication.listener.doctrine'      => [
                'class'        => \MauticPlugin\CrateReplicationBundle\EventListener\DoctrineListener::class,
                'tag'          => 'doctrine.event_listener',
                'tagArguments' => [
                    'event' => 'postPersist',
                    'lazy'  => true
                ],
                'arguments'    => [
                    'mautic.cache.adapter.redis',
                    'mautic.crate_replication.settings',
                    'mautic.crate_replication.tick_manager'
                ]
            ],
            'mautic.crate_replication.settings'               => [
                'class'     => \MauticPlugin\CrateReplicationBundle\Config\Settings::class,
                'arguments' => [
                    'mautic.helper.core_parameters'
                ]
            ],
            'mautic.crate_replication.connection'             => [
                'class'     => \MauticPlugin\CrateReplicationBundle\Crate\Connection::class,
                'arguments' => [
                    'mautic.helper.core_parameters'
                ]
            ],
            'mautic.crate_replication.factory.entity_manager' => [
                'class'     => \MauticPlugin\CrateReplicationBundle\Crate\EntityManagerFactory::class,
                'arguments' => [
                    'mautic.helper.core_parameters'
                ]
            ],
//            'mautic.crate_replication.logger' => [
//                'class'     => \MauticPlugin\CrateReplicationBundle\Logger\Logger::class,
//                'arguments' => [
//                    '@logger'
//                ]
//            ]
        ],
        'models'       => [
        ],
        'integrations' => [
            'mautic.crate_replication'        => [
                'class' => \MauticPlugin\CrateReplicationBundle\Integration\CrateReplicationIntegration::class,
                'tags'  => [
                    'mautic.basic_integration'
                ],
            ],
            'mautic.crate_replication.config' => [
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

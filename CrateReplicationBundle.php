<?php

declare(strict_types=1);

/*
 * @copyright   Galvani, Jan Kozak <galvani78@gmail.dom>
 * @author      Jan Kozak <galvani78@gmail.dom>
 *
 * @link        https://github.com/galvani
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\CrateReplicationBundle;

use Mautic\PluginBundle\Bundle\PluginBundleBase;
use MauticPlugin\CrateReplicationBundle\DependencyInjection\Compiler\TickPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CrateReplicationBundle extends PluginBundleBase
{
    public const BUNDLE_DISPLAY_NAME='Galvani Crate Replication';
    public const BUNDLE_NAME='CrateReplication';

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TickPass());
    }

    /** @inheritDoc */
    public function getParent() {}
}

<?php

/*
 * @copyright   2018 Mautic, Inc. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://mautic.com
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

?>

<?php echo $view['form']->start($form); ?>
<ul class="nav nav-tabs">
    <!-- Enabled\Auth -->
    <li class="<?php if ($activeTab == 'details-container'): echo 'active'; endif; ?> " id="details-tab">
        <a href="#details-container" role="tab" data-toggle="tab">
            <?php echo $view['translator']->trans('mautic.plugin.integration.tab.details'); ?>
        </a>
    </li>
</ul>

<div class="tab-content pa-md bg-white">
    <div class="tab-pane fade in active bdr-w-0" id="details-container">
        <?php echo $view['form']->row($form['isPublished']); ?>
    </div>
</div>

<?php echo $view['form']->end($form); ?>

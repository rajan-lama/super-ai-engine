<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://rithemes.com
 * @since      1.0.0
 *
 * @package    Super_Ai_Engine
 * @subpackage Super_Ai_Engine/admin/partials
 */
?>
<div class="sai-engine-dashboard">
    <?php $title = __('Engine Dashboard', 'super-ai-engine'); ?>
    <?php include_once 'super-ai-engine-admin-header.php'; ?>

    <div class="sai-engine-dashboard-container">
        <div class="sai-engine-dashboard-row">
            <div class="sai-engine-dashboard-col-3">Col-3</div>
            <div class="sai-engine-dashboard-col-6">Col-6</div>
            <div class="sai-engine-dashboard-col-3">Col-3</div>
        </div>
    </div>
</div>
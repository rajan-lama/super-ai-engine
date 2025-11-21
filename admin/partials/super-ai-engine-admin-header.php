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
<div class="sai-engine-dashboard-header">
    <div class="sai-engine-dashboard-header-content-left">    
        <div class="sai-engine-dashboard-logo-section">
            <a href="<?php echo admin_url( 'admin.php?page=sai-engine-dashboard' ); ?>" class="sai-engine-button-logo-link" >
                <img class="sai-engine-dashboard-logo" width="100" src="<?php echo SUPER_AI_ENGINE_PLUGIN_URL . '/admin/images/super-AI-Engine.jpg'; ?>" alt="Super AI Engine Logo" />
            </a>
            <div class="sai-engine-dashboard-title-section">
                <h1><?php echo esc_html( $title ); ?></h1>
                <p>By Ri Themes</p>
            </div>
        </div>
        
    </div>
    <div class="sai-engine-dashboard-header-content-right">
        <a href="<?php echo admin_url( 'admin.php?page=generate-content' ); ?>" class="sai-engine-button">Content</a>
        <a href="<?php echo admin_url( 'admin.php?page=generate-image' ); ?>" class="sai-engine-button">Image</a>
        <a href="<?php echo admin_url( 'admin.php?page=generate-audio' ); ?>" class="sai-engine-button">Audio</a>
        <a href="<?php echo admin_url( 'admin.php?page=generate-video' ); ?>" class="sai-engine-button">Video</a>
      <!--  <a href="https://rithemes.com/wordpress-plugins/super-ai-engine" target="_blank" class="sai-engine-button get-pro">Get Pro</a>
        <a href="https://rithemes.com/support/" target="_blank" class="sai-engine-button get-support">Get Support</a>
-->
        <a href="<?php echo admin_url( 'admin.php?page=sai-engine-settings' ); ?>" class="sai-engine-button settings"><span class="dashicons dashicons-admin-generic"></span></a>
    </div>  
</div>
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

if (!current_user_can('manage_options')) {
    return;
}

$options = get_option( $this->option_name, [] );

$option_name = $this->option_name;
?>

<div class="sai-engine-dashboard">
    <?php $title = __('Settings', 'super-ai-engine'); ?>
    <?php include_once 'super-ai-engine-admin-header.php'; ?>

    <div class="sai-engine-dashboard-container">
        <div class="sai-engine-dashboard-row">
            <div class="sai-engine-dashboard-col-6">
                <form method="post"  action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                    <?php wp_nonce_field( 'sai_engine_settings', 'sai_engine_settings_nonce' ); ?>
                    <h3><?php esc_html_e( 'API Key', 'super-ai-engine' ); ?></h3>
                    <input type="hidden" name="action" value="sai_engine_save_settings" />
                    <input type='password' name="<?php echo esc_attr( $option_name ); ?>[api_key]" value='<?php echo esc_attr( $options['api_key'] ?? '' ); ?>' style='width:100%' />
                    <p class='description'>Please insert your google api key. You can create you api key from <a href="https://aistudio.google.com/api-keys">here.</a></p>
                    <?php submit_button(); ?>
                </form>
            </div>
            <div class="sai-engine-dashboard-col-6"></div>
        </div>
    </div>

</div>
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
                <form method="post"  action="">
                <h3><?php esc_html_e( 'API Key', 'super-ai-engine' ); ?></h3>
                    <?php 
                        $opts = get_option( $this->option_name, [] );
                        $val = esc_attr( $opts['api_key'] ?? '' );
                    ?>
                <input type='text' name="<?php echo $option_name; ?>[api_key]" value='<?php echo esc_html( $val) ; ?>' style='width:100%' />
                <?php submit_button(); ?>
                    <?php
                    // settings_fields($this->option_name);
                    // do_settings_sections('sai_enginee');
                    // $opts = get_option($this->option_name, []);

                    // var_dump( $opts);
                    // $val = esc_attr($opts['api_key'] ?? '');
                    // echo "<input type='text' name='{$this->option_name}[api_key]' value='$val' style='width:60%' />";
                    // echo "<p class='description'>Your Google API key (or leave empty if you plan to use service account server-side auth).</p>";
                    
                    // submit_button();
                    ?>
                </form>
            </div>
            <div class="sai-engine-dashboard-col-6"></div>
        </div>
    </div>

</div>
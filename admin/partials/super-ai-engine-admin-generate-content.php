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
    <?php $title = __('Generate Content', 'super-ai-engine'); ?>
    <?php include_once 'super-ai-engine-admin-header.php'; ?>

    <div class="sai-engine-dashboard-container">
        <div class="sai-engine-dashboard-row">
            <div class="sai-engine-dashboard-col-3">
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('sai_engine_generate'); ?>
                    <input type="hidden" name="action" value="sai_engine_generate" />
                    <p>
                        <h5 class="sai_engine_prompt">Prompt</h5>
                        <textarea id="sai_engine_prompt" name="prompt" rows="6"></textarea>
                    </p>
                    <p>
                        <h5 class="sai_engine_title">Post Title</h5>
                        <input id="sai_engine_title" name="post_title" type="text" style="width:60%" />
                    </p>
                    <?php submit_button('Generate & Create Post'); ?>
                </form>
            </div>
            <div class="sai-engine-dashboard-col-6">Col-6</div>
            <div class="sai-engine-dashboard-col-3">Col-3</div>
        </div>
    </div>

</div>
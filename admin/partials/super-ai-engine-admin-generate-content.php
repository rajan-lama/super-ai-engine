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

$options = get_option($this->option_name, []);

$option_name = $this->option_name;

if (! array_key_exists('post_type', $options)) {
    $options['post_type'] = 'post';
}

if (! array_key_exists('language', $options)) {
    $options['language'] = 'english';
}

if (! array_key_exists('env', $options)) {
    $options['env'] = 'default';
}

if (! array_key_exists('model', $options)) {
    $options['model'] = 'default';
}

if (! array_key_exists('temperature', $options)) {
    $options['temperature'] = 0.8;
}

if (! array_key_exists('max_length', $options)) {
    $options['max_length'] = 500;
}

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
                    <h4 class="sai_engine_prompt">Topic</h4>
                    <textarea id="sai_engine_prompt" name="prompt" rows="6"></textarea>
                    </p>
                    <button type="button" id="sai_engine_generate_content_button" class="button button-primary">Generate Content</button>
                </form>
            </div>
            <div class="sai-engine-dashboard-col-6">
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('sai_engine_create_post'); ?>
                    <input type="hidden" name="action" value="sai_engine_create_post" />
                    <p>
                    <h4 class="sai_engine_title">Title</h4>
                    <input id="sai_engine_title" name="post_title" type="text" />
                    </p>
                    <p>
                    <h4 class="sai_engine_title">Content</h4>
                    <textarea id="sai_engine_content" name="post_content" rows="10"></textarea>
                    </p>
                    <p>
                    <h4 class="sai_engine_title">Excerpt</h4>
                    <textarea id="sai_engine_excerpt" name="post_excerpt" rows="6"></textarea>
                    </p>
                    </p>
                    <?php submit_button('Create Article'); ?>
                </form>
            </div>
            <div class="sai-engine-dashboard-col-3">
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('sai_engine_generate_content_options'); ?>
                    <input type="hidden" name="action" value="sai_engine_generate_content_options" />
                    <h3><?php _e('Generator Options', 'super-ai-engine'); ?></h3>
                    <p>
                    <h4 class="sai_engine_label">Post types</h4>
                    <select id="sai_engine_post_type" name="post_type" class="sai_input">
                        <option value="post" <?php selected($options['post_type'], 'post'); ?>>Post</option>
                        <option value="page" <?php selected($options['post_type'], 'page'); ?>>Page</option>
                    </select>
                    </p>
                    <p>
                    <h4 class="sai_engine_label">Language</h4>
                    <select id="sai_engine_language" name="language" class="sai_input">
                        <option value="english" <?php selected($options['language'], 'english'); ?>>English</option>
                        <option value="french" <?php selected($options['language'], 'french'); ?>>French</option>
                    </select>
                    </p>
                    <p>
                    <h4 class="sai_engine_label">Environment</h4>
                    <select id="sai_engine_env" name="language" class="sai_input">
                        <option value="default" <?php selected($options['env'], 'default'); ?>>Default</option>
                        <option value="gemini" <?php selected($options['env'], 'gemini'); ?>>Gemini</option>
                    </select>
                    </p>
                    <p>
                    <h4 class="sai_engine_label">Model</h4>
                    <select id="sai_engine_model" name="model" class="sai_input">
                        <option value="default" <?php selected($options['model'], 'default'); ?>>Default</option>
                        <option value="gemini-2.5-flash" <?php selected($options['model'], 'gemini-2.5-flash'); ?>>Gemini 2.5 Flash</option>
                    </select>
                    </p>
                    <p>
                    <h4 class="sai_engine_label">Temperature</h4>
                    <input id="sai_engine_temperature" name="temperature" type="number" step="0.1" min="0" max="1" value="<?php echo esc_attr($options['temperature'] ?? '0.8'); ?>" class="sai_input" />
                    </p>
                    <p>
                    <h4 class="sai_engine_label">Max Word Length</h4>
                    <input id="sai_engine_max_length" name="max_length" type="number" min="50" max="3000" value="<?php echo esc_attr($options['max_length'] ?? '500'); ?>" class="sai_input" />
                    </p>
                </form>
            </div>
        </div>
    </div>

</div>
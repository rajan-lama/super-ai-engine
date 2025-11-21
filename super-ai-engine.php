<?php

/**
 * Plugin Name: Super AI Engine
 * Description: Super AI Engine is a simple WordPress plugin that allows you to generate content using the Google Gemini API. It provides an admin interface to enter your API key and model, and a form to submit prompts for content generation.
 * Version: 1.0.0
 * Author: lamarajan
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit;
}

class SAI_Engine
{
    private $option_name = 'sai_engine_settings';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_post_sai_engine', [$this, 'handle_generate']);
    }

    public function admin_menu()
    {
        add_menu_page('Super AI Engine', 'Super AI Engine', 'manage_options', 'super_ai_engine', [$this, 'settings_page']);
    }

    public function register_settings()
    {
        register_setting($this->option_name, $this->option_name, [$this, 'validate_settings']);
        add_settings_section('sai_engine_main', 'Settings', null, 'sai_engine');
        add_settings_field('api_key', 'API Key', [$this, 'field_api_key'], 'sai_engine', 'sai_engine_main');
        add_settings_field('model', 'Model', [$this, 'field_model'], 'sai_engine', 'sai_engine_main');
    }

    public function validate_settings($input)
    {
        $out = [];
        $out['api_key'] = sanitize_text_field($input['api_key'] ?? '');
        $out['model'] = sanitize_text_field($input['model'] ?? 'gemini-1.5');
        return $out;
    }

    public function field_api_key()
    {
        $opts = get_option($this->option_name, []);
        $val = esc_attr($opts['api_key'] ?? '');
        echo "<input type='text' name='{$this->option_name}[api_key]' value='$val' style='width:60%' />";
        echo "<p class='description'>Your Google API key (or leave empty if you plan to use service account server-side auth).</p>";
    }

    public function field_model()
    {
        $opts = get_option($this->option_name, []);
        $val = esc_attr($opts['model'] ?? 'gemini-1.5');
        echo "<input type='text' name='{$this->option_name}[model]' value='$val' />";
        echo "<p class='description'>Model name to call (example: gemini-1.5, gemini-2.5-flash, chat-bison-001). Check Google docs for available models.</p>";
    }

    public function settings_page()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
?>
        <div class="wrap">
            <h1>WP Gemini Content Generator</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields($this->option_name);
                do_settings_sections('sai_engine');
                submit_button();
                ?>
            </form>

            <h2>Generate Content</h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('sai_engine_generate'); ?>
                <input type="hidden" name="action" value="sai_engine_generate" />
                <table class="form-table">
                    <tr>
                        <th><label for="sai_engine_prompt">Prompt</label></th>
                        <td><textarea id="sai_engine_prompt" name="prompt" rows="6" cols="80"></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="sai_engine_title">Post Title</label></th>
                        <td><input id="sai_engine_title" name="post_title" type="text" style="width:60%" /></td>
                    </tr>
                </table>
                <?php submit_button('Generate & Create Post'); ?>
            </form>

            <p><strong>Important:</strong> This is a demo. Review generated content before publishing. For production use, prefer server-side service-account authentication and respect Google's Terms of Service.</p>
        </div>
<?php
    }

    public function handle_generate()
    {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized', 403);
        }
        check_admin_referer('sai_engine_generate');

        $prompt = wp_unslash($_POST['prompt'] ?? '');
        $title = sanitize_text_field($_POST['post_title'] ?? 'Generated Post');

        if (empty($prompt)) {
            wp_safe_redirect(add_query_arg('msg', 'empty_prompt', wp_get_referer()));
            exit;
        }

        $opts = get_option($this->option_name, []);
        $api_key = $opts['api_key'] ?? '';
        $model = $opts['model'] ?? 'gemini-1.5';

        // Build request body according to Generative Language / Vertex text generation REST examples.
        // We're using the v1beta2 style 'generateMessage' REST endpoint pattern as a simple example.
        $endpoint = "https://generativelanguage.googleapis.com/v1beta2/models/" . rawurlencode($model) . ":generateMessage";
        if (!empty($api_key)) {
            $endpoint = add_query_arg('key', $api_key, $endpoint);
        }

        $body = [
            'prompt' => [
                'messages' => [
                    ['content' => $prompt]
                ]
            ],
            // optional params can be added here, e.g. temperature, maxOutputTokens etc depending on API
        ];

        $args = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => wp_json_encode($body),
            'timeout' => 30,
        ];

        $response = wp_remote_post($endpoint, $args);

        if (is_wp_error($response)) {
            $err = $response->get_error_message();
            wp_die('Request error: ' . esc_html($err));
        }

        $code = wp_remote_retrieve_response_code($response);
        $resp_body = wp_remote_retrieve_body($response);
        $data = json_decode($resp_body, true);

        if ($code < 200 || $code >= 300) {
            wp_die('API error: HTTP ' . intval($code) . ' — ' . esc_html($resp_body));
        }

        // Parse the API response. Different endpoints return different structures; adjust as needed.
        $generated_text = '';
        if (isset($data['candidates'][0]['content'])) {
            // some variants return candidates
            $generated_text = $data['candidates'][0]['content'];
        } elseif (isset($data['output'][0]['content'])) {
            $generated_text = $data['output'][0]['content'];
        } elseif (isset($data['predictions'][0]['content'])) {
            $generated_text = $data['predictions'][0]['content'];
        } elseif (isset($data['answer'])) {
            $generated_text = $data['answer'];
        } else {
            // Fallback: try to find text fields
            $flat = print_r($data, true);
            $generated_text = "(Could not find generated text in response — raw response: )\n" . $flat;
        }

        // Create WP post (draft)
        $post_id = wp_insert_post([
            'post_title' => $title,
            'post_content' => $generated_text,
            'post_status' => 'draft',
            'post_author' => get_current_user_id(),
        ]);

        if (is_wp_error($post_id)) {
            wp_die('Failed to create post: ' . esc_html($post_id->get_error_message()));
        }

        wp_safe_redirect(admin_url('post.php?post=' . intval($post_id) . '&action=edit'));
        exit;
    }
}

new SAI_Engine();

?>
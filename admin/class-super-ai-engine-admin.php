<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rithemes.com
 * @since      1.0.0
 *
 * @package    Super_Ai_Engine
 * @subpackage Super_Ai_Engine/admin
 */

namespace Super_Ai_Engine\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Super_Ai_Engine
 * @subpackage Super_Ai_Engine/admin
 * @author     Ri Themes <rajan.lama786@gmail.com>
 */
class Super_Ai_Engine_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/** Register Setting Options */
	private $option_name = 'sai_engine_settings';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action('admin_menu', [ $this, 'super_ai_engine_admin_menu'] );
		add_action('admin_post_sai_engine_generate', [$this, 'handle_generate']);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Super_Ai_Engine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Super_Ai_Engine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/super-ai-engine-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Super_Ai_Engine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Super_Ai_Engine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/super-ai-engine-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function super_ai_engine_admin_menu() {
		add_menu_page(
			'Super AI Engine Dashboard',           // Page title
			'Super AI Engine',          // Menu title
			'manage_options',           // Capability
			'sai-engine-dashboard',     // Menu slug (unique)
			[ $this, 'super_ai_engine_page_callback' ], // callback (callable array)
			'dashicons-admin-generic',  // Icon
			6                           // Position
		);

		add_submenu_page(
			'sai-engine-dashboard',    // Parent slug
			'Generate Content',            // Page title
			'Generate Content',        // Menu title
			'manage_options',          // Capability
			'generate-content',       // Menu slug
			[ $this, 'super_ai_engine_generate_content_callback' ] // callback (callable array)
		);

		add_submenu_page(
			'sai-engine-dashboard',    // Parent slug
			'Generate Image',            // Page title
			'Generate Image',          // Menu title
			'manage_options',          // Capability
			'generate-image',       // Menu slug
			[ $this, 'super_ai_engine_generate_image_callback' ] // callback (callable array)
		);

		add_submenu_page(
			'sai-engine-dashboard',    // Parent slug
			'Generate Audio',            // Page title
			'Generate Audio',          // Menu title
			'manage_options',          // Capability
			'generate-audio',       // Menu slug
			[ $this, 'super_ai_engine_generate_audio_callback' ] // callback (callable array)
		);

		add_submenu_page(
			'sai-engine-dashboard',    // Parent slug
			'Generate Video',            // Page title
			'Generate Video',          // Menu title
			'manage_options',          // Capability
			'generate-video',       	// Menu slug
			[ $this, 'super_ai_engine_generate_video_callback' ] // callback (callable array)
		);

		add_submenu_page(
			'sai-engine-dashboard',          // Parent slug
			'Super AI Engine Settings',            // Page title
			'Settings',        			// Menu title
			'manage_options',          // Capability
			'sai-engine-settings',       // Menu slug
			[ $this, 'super_ai_engine_settings_callback' ] // callback (callable array)
		);
	}

	function super_ai_engine_page_callback() {
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-dashboard.php';	
	}


	function super_ai_engine_generate_audio_callback() {
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-generate-audio.php';
	}

	function super_ai_engine_generate_content_callback() {
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-generate-content.php';
	}

	function super_ai_engine_generate_video_callback() {
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-generate-video.php';
	}

	function super_ai_engine_generate_image_callback() {
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-generate-image.php';
	}

	function super_ai_engine_settings_callback() {
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-settings.php';
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

	
	public function handle_generate()
	{
		if (! current_user_can('manage_options')) {
			wp_die('Unauthorized', 403);
		}
		check_admin_referer('sai_engine_generate');

		$prompt = wp_unslash($_POST['prompt'] ?? '');
		$title  = sanitize_text_field($_POST['post_title'] ?? 'Generated Post');

		if (empty($prompt)) {
			wp_redirect(add_query_arg('msg', 'empty_prompt', wp_get_referer()));
			exit;
		}

		$opts    = get_option($this->option_name, []);
		$api_key = trim($opts['api_key'] ?? ''); // ensure plugin uses same key you tested with curl
		$model   = trim($opts['model'] ?? 'gemini-2.0-flash');

		// Use the same API version & endpoint shape that worked in your curl
		$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/" . rawurlencode($model) . ":generateContent";

		// Build the body exactly like your working curl
		$body = [
			'contents' => [
				[
					'parts' => [
						['text' => $prompt]
					]
				]
			]
		];

		// Headers: use X-goog-api-key like your curl example
		$headers = [
			'Content-Type' => 'application/json',
		];
		if (!empty($api_key)) {
			// Put the key in the same header you used with curl
			$headers['X-goog-api-key'] = $api_key;
		}

		$args = [
			'headers' => $headers,
			'body'    => wp_json_encode($body),
			'timeout' => 60,
		];

		$response = wp_remote_post($endpoint, $args);

		if (is_wp_error($response)) {
			wp_die('Request error: ' . esc_html($response->get_error_message()));
		}

		$code      = wp_remote_retrieve_response_code($response);
		$resp_body = wp_remote_retrieve_body($response);
		$data      = json_decode($resp_body, true);

		// If 404, attempt to list models using same API-version + header so you can see what this key actually has access to
		if ($code === 404) {
			$models_endpoint = "https://generativelanguage.googleapis.com/v1beta/models";
			$models_resp = wp_remote_get($models_endpoint, ['headers' => $headers, 'timeout' => 20]);

			if (!is_wp_error($models_resp)) {
				$models_code = wp_remote_retrieve_response_code($models_resp);
				$models_body = wp_remote_retrieve_body($models_resp);
				if ($models_code >= 200 && $models_code < 300) {
					$models_data = json_decode($models_body, true);
					$available = [];
					if (!empty($models_data['models']) && is_array($models_data['models'])) {
						foreach ($models_data['models'] as $m) {
							if (!empty($m['name'])) $available[] = $m['name'];
						}
					}
					wp_die('Requested model/method not found. Available models for your key: ' . implode(', ', $available));
				} else {
					wp_die('Requested model/method not found (404). Also failed to list models: ' . esc_html($models_body));
				}
			} else {
				wp_die('Requested model/method not found (404). Failed to call models endpoint: ' . esc_html($models_resp->get_error_message()));
			}
		}

		if ($code < 200 || $code >= 300) {
			wp_die('API error: HTTP ' . intval($code) . ' — ' . esc_html($resp_body));
		}

		// Parse expected response (your curl returned candidates[0].content.parts[0].text)
		$generated_text = '';

		if (!empty($data['candidates']) && is_array($data['candidates'])) {
			$cand = $data['candidates'][0] ?? null;
			if ($cand && !empty($cand['content']) && !empty($cand['content']['parts'])) {
				$parts = $cand['content']['parts'];
				$texts = [];
				foreach ($parts as $p) {
					if (is_array($p) && isset($p['text'])) {
						$texts[] = $p['text'];
					} elseif (is_string($p)) {
						$texts[] = $p;
					}
				}
				$generated_text = trim(implode("\n\n", $texts));
			}
		}

		// Fallbacks for other shapes
		if (empty($generated_text) && !empty($data['output'][0]['content'])) {
			$generated_text = is_string($data['output'][0]['content']) ? $data['output'][0]['content'] : wp_json_encode($data['output'][0]['content']);
		}
		if (empty($generated_text) && !empty($data['answer'])) {
			$generated_text = $data['answer'];
		}
		if (empty($generated_text)) {
			$generated_text = "(Could not find generated text — raw response:) \n" . print_r($data, true);
		}

		// Insert as draft
		$post_id = wp_insert_post([
			'post_title'   => $title,
			'post_content' => $generated_text,
			'post_status'  => 'draft',
			'post_author'  => get_current_user_id(),
		]);

		if (is_wp_error($post_id)) {
			wp_die('Failed to create post: ' . esc_html($post_id->get_error_message()));
		}

		wp_redirect(admin_url('post.php?post=' . intval($post_id) . '&action=edit'));
		exit;
	}

}


// Helper: add_query_arg wrapper that works in this file's scope
if (!function_exists('add_query_arg')) {
    function add_query_arg($key, $value, $url)
    {
        $sep = (strpos($url, '?') === false) ? '?' : '&';
        return $url . $sep . rawurlencode($key) . '=' . rawurlencode($value);
    }
}

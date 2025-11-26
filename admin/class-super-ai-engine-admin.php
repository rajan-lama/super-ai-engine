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
class Super_Ai_Engine_Admin
{

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
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action('admin_menu', [$this, 'super_ai_engine_admin_menu']);
		add_action('admin_post_sai_engine_save_settings', [$this, 'save_settings']);
		add_action('admin_post_sai_engine_create_post', [$this, 'handle_sai_engine_create_post']);

		add_action('wp_ajax_sai_engine_generate', array($this, 'handle_sai_engine_generate'));
		add_action('wp_ajax_nopriv_sai_engine_generate', array($this, 'handle_sai_engine_generate'));

		add_action('wp_ajax_sai_engine_generate_content_options', array($this, 'handle_sai_engine_generate_content_options'));
		add_action('wp_ajax_nopriv_sai_engine_generate_content_options', array($this, 'handle_sai_engine_generate_content_options'));

		add_action('wp_ajax_sai_engine_create_post', array($this, 'handle_sai_engine_create_post'));
		add_action('wp_ajax_nopriv_sai_engine_create_post', array($this, 'handle_sai_engine_create_post'));
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/super-ai-engine-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/super-ai-engine-admin.js', array('jquery'), $this->version, false);
		wp_localize_script($this->plugin_name, 'sai_ajax', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('sai_engine_generate'),
			'site_url' => SUPER_AI_ENGINE_PLUGIN_URL,
		));
	}

	public function super_ai_engine_admin_menu()
	{
		add_menu_page(
			'Super AI Engine Dashboard',           // Page title
			'Super AI Engine',          // Menu title
			'manage_options',           // Capability
			'sai-engine-dashboard',     // Menu slug (unique)
			[$this, 'super_ai_engine_settings_callback'], // callback (callable array)
			'dashicons-admin-generic',  // Icon
			6                           // Position
		);

		// add_menu_page(
		// 	'Super AI Engine Dashboard',           // Page title
		// 	'Super AI Engine',          // Menu title
		// 	'manage_options',           // Capability
		// 	'sai-engine-dashboard',     // Menu slug (unique)
		// 	[ $this, 'super_ai_engine_page_callback' ], // callback (callable array)
		// 	'dashicons-admin-generic',  // Icon
		// 	6                           // Position
		// );

		add_submenu_page(
			'sai-engine-dashboard',    // Parent slug
			'Generate Content',            // Page title
			'Generate Content',        // Menu title
			'manage_options',          // Capability
			'generate-content',       // Menu slug
			[ $this, 'super_ai_engine_generate_content_callback' ] // callback (callable array)
		);

		// add_submenu_page(
		// 	'sai-engine-dashboard',    // Parent slug
		// 	'Generate Image',            // Page title
		// 	'Generate Image',          // Menu title
		// 	'manage_options',          // Capability
		// 	'generate-image',       // Menu slug
		// 	[ $this, 'super_ai_engine_generate_image_callback' ] // callback (callable array)
		// );

		// add_submenu_page(
		// 	'sai-engine-dashboard',    // Parent slug
		// 	'Generate Audio',            // Page title
		// 	'Generate Audio',          // Menu title
		// 	'manage_options',          // Capability
		// 	'generate-audio',       // Menu slug
		// 	[ $this, 'super_ai_engine_generate_audio_callback' ] // callback (callable array)
		// );

		// add_submenu_page(
		// 	'sai-engine-dashboard',    // Parent slug
		// 	'Generate Video',            // Page title
		// 	'Generate Video',          // Menu title
		// 	'manage_options',          // Capability
		// 	'generate-video',       	// Menu slug
		// 	[ $this, 'super_ai_engine_generate_video_callback' ] // callback (callable array)
		// );

		// add_submenu_page(
		// 	'sai-engine-dashboard',          // Parent slug
		// 	'Super AI Engine Settings',            // Page title
		// 	'Settings',        			// Menu title
		// 	'manage_options',          // Capability
		// 	'sai-engine-settings',       // Menu slug
		// 	[$this, 'super_ai_engine_settings_callback'] // callback (callable array)
		// );
	}

	function super_ai_engine_page_callback()
	{
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-dashboard.php';
	}


	function super_ai_engine_generate_audio_callback()
	{
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-generate-audio.php';
	}

	function super_ai_engine_generate_content_callback()
	{
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-generate-content.php';
	}

	function super_ai_engine_generate_video_callback()
	{
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-generate-video.php';
	}

	function super_ai_engine_generate_image_callback()
	{
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-generate-image.php';
	}

	function super_ai_engine_settings_callback()
	{
		include_once SUPER_AI_ENGINE_PLUGIN_DIR . 'admin/partials/super-ai-engine-admin-settings.php';
	}

	// public function handle_generate()
	// {
	// 	if (! current_user_can('manage_options')) {
	// 		wp_die('Unauthorized', 403);
	// 	}
	// 	check_admin_referer('sai_engine_generate');

	// 	$prompt = wp_unslash($_POST['prompt'] ?? '');
	// 	$title  = sanitize_text_field($_POST['post_title'] ?? 'Generated Post');

	// 	if (empty($prompt)) {
	// 		wp_redirect(add_query_arg('msg', 'empty_prompt', wp_get_referer()));
	// 		exit;
	// 	}

	// 	$opts    = get_option($this->option_name, []);
	// 	$api_key = trim($opts['api_key'] ?? ''); // ensure plugin uses same key you tested with curl
	// 	$model   = trim($opts['model'] ?? 'gemini-2.0-flash');

	// 	// Use the same API version & endpoint shape that worked in your curl
	// 	$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/" . rawurlencode($model) . ":generateContent";

	// 	// Build the body exactly like your working curl
	// 	$body = [
	// 		'contents' => [
	// 			[
	// 				'parts' => [
	// 					['text' => $prompt]
	// 				]
	// 			]
	// 		]
	// 	];

	// 	// Headers: use X-goog-api-key like your curl example
	// 	$headers = [
	// 		'Content-Type' => 'application/json',
	// 	];
	// 	if (!empty($api_key)) {
	// 		// Put the key in the same header you used with curl
	// 		$headers['X-goog-api-key'] = $api_key;
	// 	}

	// 	$args = [
	// 		'headers' => $headers,
	// 		'body'    => wp_json_encode($body),
	// 		'timeout' => 60,
	// 	];

	// 	$response = wp_remote_post($endpoint, $args);

	// 	if (is_WP_Error($response)) {
	// 		wp_die('Request error: ' . esc_html($response->get_error_message()));
	// 	}

	// 	$code      = wp_remote_retrieve_response_code($response);
	// 	$resp_body = wp_remote_retrieve_body($response);
	// 	$data      = json_decode($resp_body, true);

	// 	// If 404, attempt to list models using same API-version + header so you can see what this key actually has access to
	// 	if ($code === 404) {
	// 		$models_endpoint = "https://generativelanguage.googleapis.com/v1beta/models";
	// 		$models_resp = wp_remote_get($models_endpoint, ['headers' => $headers, 'timeout' => 20]);

	// 		if (!is_WP_Error($models_resp)) {
	// 			$models_code = wp_remote_retrieve_response_code($models_resp);
	// 			$models_body = wp_remote_retrieve_body($models_resp);
	// 			if ($models_code >= 200 && $models_code < 300) {
	// 				$models_data = json_decode($models_body, true);
	// 				$available = [];
	// 				if (!empty($models_data['models']) && is_array($models_data['models'])) {
	// 					foreach ($models_data['models'] as $m) {
	// 						if (!empty($m['name'])) $available[] = $m['name'];
	// 					}
	// 				}
	// 				wp_die('Requested model/method not found. Available models for your key: ' . implode(', ', $available));
	// 			} else {
	// 				wp_die('Requested model/method not found (404). Also failed to list models: ' . esc_html($models_body));
	// 			}
	// 		} else {
	// 			wp_die('Requested model/method not found (404). Failed to call models endpoint: ' . esc_html($models_resp->get_error_message()));
	// 		}
	// 	}

	// 	if ($code < 200 || $code >= 300) {
	// 		wp_die('API error: HTTP ' . intval($code) . ' — ' . esc_html($resp_body));
	// 	}

	// 	// Parse expected response (your curl returned candidates[0].content.parts[0].text)
	// 	$generated_text = '';

	// 	if (!empty($data['candidates']) && is_array($data['candidates'])) {
	// 		$cand = $data['candidates'][0] ?? null;
	// 		if ($cand && !empty($cand['content']) && !empty($cand['content']['parts'])) {
	// 			$parts = $cand['content']['parts'];
	// 			$texts = [];
	// 			foreach ($parts as $p) {
	// 				if (is_array($p) && isset($p['text'])) {
	// 					$texts[] = $p['text'];
	// 				} elseif (is_string($p)) {
	// 					$texts[] = $p;
	// 				}
	// 			}
	// 			$generated_text = trim(implode("\n\n", $texts));
	// 		}
	// 	}

	// 	// Fallbacks for other shapes
	// 	if (empty($generated_text) && !empty($data['output'][0]['content'])) {
	// 		$generated_text = is_string($data['output'][0]['content']) ? $data['output'][0]['content'] : wp_json_encode($data['output'][0]['content']);
	// 	}
	// 	if (empty($generated_text) && !empty($data['answer'])) {
	// 		$generated_text = $data['answer'];
	// 	}
	// 	if (empty($generated_text)) {
	// 		$generated_text = "(Could not find generated text — raw response:) \n" . print_r($data, true);
	// 	}

	// 	// Insert as draft
	// 	$post_id = wp_insert_post([
	// 		'post_title'   => $title,
	// 		'post_content' => $generated_text,
	// 		'post_status'  => 'draft',
	// 		'post_author'  => get_current_user_id(),
	// 	]);

	// 	if (is_WP_Error($post_id)) {
	// 		wp_die('Failed to create post: ' . esc_html($post_id->get_error_message()));
	// 	}

	// 	wp_redirect(admin_url('post.php?post=' . intval($post_id) . '&action=edit'));
	// 	exit;
	// }


	/**
	 * Generate article pieces with Gemini: title -> headings -> article -> excerpt.
	 *
	 * Returns array on success:
	 *   [
	 *     'title'    => 'Generated Title',
	 *     'sections' => "## heading1\n## heading2\n...", // raw markdown headings block
	 *     'article'  => 'Full markdown article text',
	 *     'excerpt'  => 'short excerpt'
	 *   ]
	 *
	 * Or \WP_Error on failure.
	 */
	public function generate_article_pipeline($topic, $context = '', $language = 'English', $sections_count = 4, $paragraphs_per_section = 2)
	{
		// Basic validation
		$topic = trim((string) $topic);
		if ($topic === '') {
			return new \WP_Error('missing_topic', 'Topic is required.');
		}
		$context = trim((string) $context);
		$language = trim((string) $language);
		$sections_count = max(1, intval($sections_count));
		$paragraphs_per_section = max(1, intval($paragraphs_per_section));

		// Config
		$opts    = get_option($this->option_name, []);
		$api_key = trim($opts['api_key'] ?? '');
		$model   = trim($opts['model'] ?? 'gemini-2.0-flash');

		// Retry & validation settings
		$max_attempts = 4;
		$min_len = 40;
		$max_len = 60;


		/**
		 * Helper: create prompt templates (kept inside for encapsulation)
		 */
		$templates = [
			'title' => <<<TPL
Write a title for an article in {LANGUAGE}. Must be between {MIN_LEN} and {MAX_LEN} characters. Write naturally as a human would. Output only the title, no formatting, no Markdown, no special characters.

### TOPIC:
{TOPIC}

### CONTEXT:
{CONTEXT}

Generate a title based on the topic above, taking into account the provided context.
TPL,
			'sections' => <<<TPL
Write {SECTIONS_COUNT} consecutive headings for an article about "{TITLE}", in {LANGUAGE}. Each heading is between {MIN_LEN} and {MAX_LEN} characters. Format each heading with Markdown (## ). Write naturally as a human would. Output only the headings, nothing else.

### TOPIC:
{TOPIC}

### CONTEXT:
{CONTEXT}

Create headings that align with both the topic and context provided above.
TPL,
			'article' => <<<TPL
Write an article about "{TITLE}" in {LANGUAGE}. Write {PARAGRAPHS_PER_SECTION} paragraphs per heading. Use Markdown for formatting. Add an introduction prefixed by "===INTRO: ", and a conclusion prefixed by "===OUTRO: ". Write naturally as a human would.

### ARTICLE STRUCTURE:
{SECTIONS}

### TOPIC DETAILS:
{TOPIC}

### WRITING CONTEXT:
{CONTEXT}

Write the article following the structure above, incorporating the topic details while adhering to the context guidelines.
TPL,
			'excerpt' => <<<TPL
Write an excerpt for an article in {LANGUAGE}. Must be between {MIN_LEN} and {MAX_LEN} characters. Write naturally as a human would. Output only the excerpt, no formatting.

### ARTICLE TITLE:
"{TITLE}"

### TOPIC:
{TOPIC}

### CONTEXT:
{CONTEXT}

Create a compelling excerpt that captures the essence of the article while considering the context.
TPL
		];

		/**
		 * Helper to fill templates
		 */
		$fill = function ($template, $vars) {
			$search = [];
			$replace = [];
			foreach ($vars as $k => $v) {
				$search[] = '{' . $k . '}';
				$replace[] = $v;
			}
			return str_replace($search, $replace, $template);
		};

		/**
		 * Helper: call Gemini (wp_remote_post). Tries ?key= fallback.
		 * Returns array-decoded JSON on success, \WP_Error on failure.
		 */
		$call_gemini = function ($payload) use ($api_key, $model) {
			$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/" . rawurlencode($model) . ":generateContent";
			$headers = ['Content-Type' => 'application/json'];

			// Use ?key= fallback if api_key present (some setups accept this)
			$url = $endpoint;
			if (! empty($api_key)) {
				$url .= '?key=' . rawurlencode($api_key);
				// Optionally also send X-goog-api-key header if desired:
				// $headers['X-goog-api-key'] = $api_key;
			}

			$args = [
				'headers' => $headers,
				'body'    => wp_json_encode($payload),
				'timeout' => 60,
			];

			$resp = wp_remote_post($url, $args);
			if (is_WP_Error($resp)) {
				return $resp;
			}

			$code = wp_remote_retrieve_response_code($resp);
			$body = wp_remote_retrieve_body($resp);


			if ($code < 200 || $code >= 300) {
				// Log raw body for debugging
				error_log('[generate_article_pipeline] Gemini HTTP ' . intval($code) . ' response: ' . wp_trim_words($body, 80, '...'));
				return new \WP_Error('gemini_http', 'Gemini request failed: HTTP ' . intval($code));
			}

			$data = json_decode($body, true);
			if ($data === null) {
				error_log('[generate_article_pipeline] Gemini JSON decode failed. Raw: ' . substr($body, 0, 2000));
				return new \WP_Error('gemini_json', 'Failed to decode Gemini JSON response.');
			}

			return $data;
		};

		/**
		 * Helper: extract text from common Gemini shapes.
		 * Accepts decoded json array, returns plain text string (joined).
		 */
		$extract_text = function ($data) {
			// Candidates shape
			if (! empty($data['candidates']) && is_array($data['candidates'])) {
				$cand = $data['candidates'][0] ?? null;
				if ($cand) {
					// many shapes: cand.content.parts[*].text OR cand.message.content[*].text OR cand.output
					if (! empty($cand['content']['parts']) && is_array($cand['content']['parts'])) {
						$texts = [];
						foreach ($cand['content']['parts'] as $p) {
							if (is_array($p) && isset($p['text'])) $texts[] = $p['text'];
							elseif (is_string($p)) $texts[] = $p;
						}
						if (! empty($texts)) return trim(implode("\n\n", $texts));
					}
					if (! empty($cand['message']['content']) && is_array($cand['message']['content'])) {
						$texts = [];
						foreach ($cand['message']['content'] as $c) {
							if (is_string($c)) $texts[] = $c;
							elseif (is_array($c) && isset($c['text'])) $texts[] = $c['text'];
						}
						if (! empty($texts)) return trim(implode("\n\n", $texts));
					}
					if (! empty($cand['output']) && is_string($cand['output'])) {
						return trim($cand['output']);
					}
				}
			}

			// Output array shape
			if (! empty($data['output']) && is_array($data['output'])) {
				// try first item
				$first = $data['output'][0] ?? null;
				if (is_string($first)) return trim($first);
				if (is_array($first) && ! empty($first['content'])) {
					if (is_string($first['content'])) return trim($first['content']);
					return trim(wp_json_encode($first['content']));
				}
			}

			// Answer or generatedText
			if (! empty($data['answer']) && is_string($data['answer'])) return trim($data['answer']);
			if (! empty($data['generatedText']) && is_string($data['generatedText'])) return trim($data['generatedText']);

			// Fallback: stringify whole response truncated
			return trim(wp_json_encode($data));
		};

		/**
		 * Step A: Title (validate length)
		 */
		$title_template_vars = [
			'LANGUAGE' => $language,
			'MIN_LEN'  => $min_len,
			'MAX_LEN'  => $max_len,
			'TOPIC'    => $topic,
			'CONTEXT'  => $context,
		];
		$title_template = $templates['title'];
		$title_prompt = $fill($title_template, $title_template_vars);

		$title = '';
		for ($attempt = 1; $attempt <= $max_attempts; $attempt++) {
			$payload = [
				'contents' => [
					[
						'role' => 'user',
						'parts' => [
							['text' => $title_prompt . "\n\nGenerate the title now."]
						]
					]
				]
			];

			$res = $call_gemini($payload);
			if (is_WP_Error($res)) {
				return $res;
			}

			$raw = $extract_text($res);
			// Clean: keep only first line, strip whitespace and quotes
			$candidate = trim(preg_replace('/^[\"\']|[\"\']$/', '', strtok($raw, "\n")));
			$len = mb_strlen($candidate);

			if ($len >= $min_len && $len <= $max_len) {
				$title = $candidate;
				break;
			}

			sleep(1);
		}

		if ($title === '') {
			return new \WP_Error('title_invalid', 'Failed to generate a valid title within length constraints.');
		}

		/**
		 * Step B: Headings (sections)
		 * We require each heading line to start with "## " and be between min/max len.
		 */
		$sections_template_vars = [
			'SECTIONS_COUNT' => $sections_count,
			'TITLE' => $title,
			'LANGUAGE' => $language,
			'MIN_LEN' => $min_len,
			'MAX_LEN' => $max_len,
			'TOPIC' => $topic,
			'CONTEXT' => $context,
		];
		$sections_prompt = $fill($templates['sections'], $sections_template_vars);

		$sections_block = '';
		for ($attempt = 1; $attempt <= $max_attempts; $attempt++) {
			$payload = [
				'contents' => [
					['role' => 'user', 'parts' => [['text' => $sections_prompt]]],
					['role' => 'user',   'parts' => [['text' => 'Generate headings now.']]]
				]
			];

			$res = $call_gemini($payload);
			if (is_WP_Error($res)) {
				return $res;
			}

			$raw = $extract_text($res);
			// Normalize line endings
			$lines = preg_split('/\r\n|\r|\n/', trim($raw));
			$valid = true;
			$clean_lines = [];

			// Only keep lines starting with ## ; if the model returns without ## try to prefix it
			foreach ($lines as $ln) {
				$ln = trim($ln);
				if ($ln === '') continue;
				if (stripos($ln, '## ') !== 0) {
					// if it looks like a heading but without hashes, add them
					if (preg_match('/^[\-–•]/', $ln)) {
						$ln = preg_replace('/^[\-–•\s]*/', '', $ln);
					}
					$ln = '## ' . $ln;
				}
				// extract visible text after "## "
				$visible = trim(preg_replace('/^##\s*/', '', $ln));
				$vlen = mb_strlen($visible);
				if ($vlen < $min_len || $vlen > $max_len) {
					$valid = false;
					break;
				}
				$clean_lines[] = '## ' . $visible;
			}

			// If the number of headings is less than expected, invalid
			if ($valid && count($clean_lines) === $sections_count) {
				$sections_block = implode("\n", $clean_lines);
				break;
			}

			error_log("[generate_article_pipeline] Sections attempt $attempt invalid (count: " . count($clean_lines) . ", valid: " . ($valid ? 1 : 0) . "). Retrying.");
			sleep(1);
		}

		if ($sections_block === '') {
			return new \WP_Error('sections_invalid', 'Failed to generate valid headings that meet constraints.');
		}

		/**
		 * Step C: Article (no strict length validation here)
		 */
		$article_template_vars = [
			'TITLE' => $title,
			'LANGUAGE' => $language,
			'PARAGRAPHS_PER_SECTION' => $paragraphs_per_section,
			'SECTIONS' => $sections_block,
			'TOPIC' => $topic,
			'CONTEXT' => $context,
		];
		$article_prompt = $fill($templates['article'], $article_template_vars);

		$article_text = '';
		$payload = [
			'contents' => [
				['role' => 'user', 'parts' => [['text' => $article_prompt]]],
				['role' => 'user',   'parts' => [['text' => 'Generate the article now.']]]
			]
		];
		$res = $call_gemini($payload);
		if (is_WP_Error($res)) {
			return $res;
		}
		$article_text = $extract_text($res);
		if (trim($article_text) === '') {
			return new \WP_Error('article_empty', 'Article generation returned empty content.');
		}

		/**
		 * Step D: Excerpt (length validated)
		 */
		$excerpt_template_vars = [
			'LANGUAGE' => $language,
			'MIN_LEN'  => $min_len,
			'MAX_LEN'  => $max_len,
			'TITLE'    => $title,
			'TOPIC'    => $topic,
			'CONTEXT'  => $context,
		];
		$excerpt_prompt = $fill($templates['excerpt'], $excerpt_template_vars);

		$excerpt = '';
		for ($attempt = 1; $attempt <= $max_attempts; $attempt++) {
			$payload = [
				'contents' => [
					['role' => 'user', 'parts' => [['text' => $excerpt_prompt]]],
					['role' => 'user',   'parts' => [['text' => 'Generate the excerpt now.']]]
				]
			];

			$res = $call_gemini($payload);
			if (is_WP_Error($res)) {
				return $res;
			}

			$raw = $extract_text($res);
			// Keep only first line
			$candidate = trim(preg_replace('/^[\"\']|[\"\']$/', '', strtok($raw, "\n")));
			$len = mb_strlen($candidate);
			if ($len >= $min_len && $len <= $max_len) {
				$excerpt = $candidate;
				break;
			}

			error_log("[generate_article_pipeline] Excerpt attempt $attempt produced length $len; retrying.");
			sleep(1);
		}

		if ($excerpt === '') {
			return new \WP_Error('excerpt_invalid', 'Failed to generate a valid excerpt within length constraints.');
		}

		// Success: return structured result
		return [
			'title'    => $title,
			'sections' => $sections_block,
			'article'  => $article_text,
			'excerpt'  => $excerpt,
		];
	}

	// AJAX handler for saving options
	public function handle_sai_engine_generate_content_options()
	{
		// Check nonce (from POST['security'])
		if (! isset($_POST['security']) || ! check_ajax_referer('sai_engine_generate', 'security', false)) {
			wp_send_json_error('Invalid nonce or missing security token.', 403);
		}

		// Capability check (only allow users who can manage options)
		if (! current_user_can('manage_options')) {
			wp_send_json_error('Unauthorized', 403);
		}

		$key = $_POST['key'] ?? '';
		$value = $_POST['value'] ?? '';

		$options = get_option($this->option_name, []);
		$options[$key] = $value;
		update_option($this->option_name, $options);
	}

	// AJAX handler for content generation
	public function handle_sai_engine_generate()
	{
		// Check nonce (from POST['security'])
		if (! isset($_POST['security']) || ! check_ajax_referer('sai_engine_generate', 'security', false)) {
			wp_send_json_error('Invalid nonce or missing security token.', 403);
		}

		// Capability check (only allow users who can manage options)
		if (! current_user_can('manage_options')) {
			wp_send_json_error('Unauthorized', 403);
		}

		// Get and sanitize prompt
		$prompt = isset($_POST['prompt']) ? sanitize_text_field(wp_unslash($_POST['prompt'])) : '';

		if (empty($prompt)) {
			wp_send_json_error('Prompt is empty.');
		}

		$result = $this->generate_article_pipeline(
			$prompt,
			'Audience: adventure travellers, tone: friendly & informative, length: ~900 words',
			'English',
			4, // sections_count
			2  // paragraphs_per_section
		);


		// Return success
		wp_send_json_success(array('content' => $result));
	}

	//AJAX handler for create post from generated content
	public function handle_sai_engine_create_post()
	{
		// Check nonce (from POST['security'])
		if (! check_admin_referer('sai_engine_create_post')) {
			wp_send_json_error('Invalid nonce or missing security token.', 403);
		}

		// Capability check (only allow users who can manage options)
		if (! current_user_can('manage_options')) {
			wp_send_json_error('Unauthorized', 403);
		}

		$options = get_option($this->option_name, []);
		$title   = isset($_POST['post_title']) ? sanitize_text_field(wp_unslash($_POST['post_title'])) : 'Generated Post';
		$content = isset($_POST['post_content']) ? wp_kses_post(wp_unslash($_POST['post_content'])) : '';
		$excerpt = isset($_POST['post_excerpt']) ? sanitize_text_field(wp_unslash($_POST['post_excerpt'])) : '';
		
		$post_id_or_err = $this->sai_insert_generated_post( $title, $content, $excerpt, [
			'post_type' => sanitize_text_field(wp_unslash($options['post_type'])) ?? 'post',
			'post_status' => 'draft',
			'post_author' => get_current_user_id(),
		] );

		if (is_WP_Error($post_id)) {
			wp_send_json_error('Failed to create post: ' . esc_html($post_id->get_error_message()));
		}

		wp_redirect(admin_url('post.php?post=' . intval($post_id) . '&action=edit'));
		exit;

		wp_send_json_success(array('post_id' => intval($post_id)));
	}

	/**
	 * Convert pipeline output (title/sections/article/excerpt) to sanitized HTML and insert/update a WP post.
	 *
	 * @param array $generated {
	 *   Required keys: 'title', 'sections', 'article', 'excerpt'
	 *   Values are strings as returned from generate_article_pipeline()
	 * }
	 * @param array $post_args Optional. Accepts keys: post_type (default 'post'), post_status (default 'draft'), post_author.
	 * @return int|\WP_Error Post ID on success, WP_Error on failure.
	 */
	function sai_insert_generated_post( string $title, string $content, string $excerpt, array $post_args = [])
	{
		// Basic validation
		if (empty($title) || empty($content)) {
			return new \WP_Error('missing_data', 'Generated title and article are required.');
		}

		// Defaults
		$defaults = [
			'post_type'   => $post_args['post_type'] ?? 'post',
			'post_status' => 'draft', // change to 'publish' to publish immediately
			'post_author' => get_current_user_id() ?: 1,
		];

		$post_args = wp_parse_args($post_args, $defaults);

		// 1) Convert the special-marked article to Markdown+HTML
		$raw_article = (string) $content;

		// normalize line endings
		$raw_article = str_replace(["\r\n", "\r"], "\n", $raw_article);

		// Extract intro (===INTRO:) up to first heading (##) if present
		$intro = '';
		$outro = '';
		$middle = $raw_article;

		if (preg_match('/===INTRO:\s*(.*?)\n(?=##\s|$)/s', $raw_article, $m)) {
			$intro = trim($m[1]);
			$middle = preg_replace('/===INTRO:\s*.*?\n(?=##\s|$)/s', '', $middle, 1);
		}

		// Extract outro (everything after ===OUTRO:)
		if (preg_match('/===OUTRO:\s*(.*)$/s', $raw_article, $m2)) {
			$outro = trim($m2[1]);
			$middle = preg_replace('/\n?===OUTRO:\s*.*$/s', '', $middle, 1);
		}

		$middle = trim($middle);

		// 2) Convert Markdown -> HTML
		$converted_middle = '';
		$converted_intro  = '';
		$converted_outro  = '';

		// If league/commonmark is available, use it (recommended)
		if (class_exists('\League\CommonMark\CommonMarkConverter')) {

			try {
				$converter = new \League\CommonMark\CommonMarkConverter([
					'html_input' => 'strip',
					'allow_unsafe_links' => false,
				]);
				$converted_middle = $middle ? $converter->convert($middle) : '';
				$converted_intro  = $intro  ? $converter->convert($intro)  : '';
				$converted_outro  = $outro  ? $converter->convert($outro)  : '';
			} catch (\Throwable $e) {
				// fallback if converter fails
				$converted_middle = esc_html($middle);
				$converted_intro  = $intro ? '<p>' . nl2br(esc_html($intro)) . '</p>' : '';
				$converted_outro  = $outro ? '<p>' . nl2br(esc_html($outro)) . '</p>' : '';
			}
		} else {
			// Fallback: escape and convert newlines to paragraphs
			$converted_middle = $middle ? wpautop(esc_html($middle)) : '';
			$converted_intro  = $intro ? '<p>' . nl2br(esc_html($intro)) . '</p>' : '';
			$converted_outro  = $outro ? '<p>' . nl2br(esc_html($outro)) . '</p>' : '';
		}

		// 3) Assemble final HTML (wrap in article container)
		$final_html = '';

		if ($converted_intro) {
			// keep the intro in a semantic wrapper and allow limited HTML
			$final_html .=  $converted_intro . "\n";
		}

		// Middle is already HTML from converter or wpautop
		$final_html .=  $converted_middle ."\n";

		if ($converted_outro) {
			$final_html .= $converted_outro ."\n";
		}

		// 4) Sanitize / allow safe HTML for storing in post_content
		// If using CommonMark converter we trust basic tags; still sanitize with wp_kses_post
		$safe_content = wp_kses_post($final_html);

		// Title & excerpt sanitization
		$safe_title   = sanitize_text_field($title);
		$safe_excerpt = isset($excerpt) ? sanitize_text_field($excerpt) : '';

		// 5) Prepare post array
		$postarr = [
			'post_title'   => wp_slash($safe_title),
			'post_content' => wp_slash($safe_content),
			'post_excerpt' => wp_slash($safe_excerpt),
			'post_status'  => $post_args['post_status'],
			'post_type'    => $post_args['post_type'],
			'post_author'  => intval($post_args['post_author']),
		];

		// If you want to save the raw markdown as meta for later editing, store it:
		// if (isset($generated['raw_markdown'])) {
		// 	$postarr['meta_input'] = ['_sai_raw_markdown' => $generated['raw_markdown']];
		// } else {
		// 	// Save original article markdown as meta for editing later
		// 	$postarr['meta_input'] = ['_sai_raw_markdown' => $raw_article];
		// }

		// 6) Insert post
		$post_id = wp_insert_post($postarr, true);

		if (is_wp_error($post_id)) {
			return $post_id;
		}

		// Optional: set categories, tags, featured image etc. Example: set post format meta
		// update_post_meta( $post_id, '_sai_generated', 1 );

		return $post_id;
	}

	public function save_settings()
	{
		if (! current_user_can('manage_options')) {
			wp_die(__('Unauthorized', 'super-ai-engine'), 403);
		}

		// Verify nonce. Field name is 'sai_engine_settings_nonce'
		check_admin_referer('sai_engine_settings', 'sai_engine_settings_nonce');

		// Load existing options (so we merge safely)
		$opts = get_option($this->option_name, []);

		// Update API key if present
		if (isset($_POST[$this->option_name]) && is_array($_POST[$this->option_name])) {
			// sanitize incoming values
			$incoming = wp_unslash($_POST[$this->option_name]);
			if (isset($incoming['api_key'])) {
				$opts['api_key'] = sanitize_text_field($incoming['api_key']);
			}
			if (isset($incoming['model'])) {
				$opts['model'] = sanitize_text_field($incoming['model']);
			}
		}

		// Save the whole options array
		update_option($this->option_name, $opts);

		// Redirect back with success message
		$redirect_to = wp_get_referer() ? wp_get_referer() : admin_url('admin.php?page=sai-engine-settings');
		$redirect_to = add_query_arg('sai_msg', 'saved', $redirect_to);
		wp_safe_redirect($redirect_to);
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

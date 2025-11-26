<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://rithemes.com
 * @since             1.0.0
 * @package           Super_Ai_Engine
 *
 * @wordpress-plugin
 * Plugin Name:       Super AI Engine
 * Plugin URI:        https://rithemes.com/wordpress-plugins/super-ai-engine
 * Description:       Super AI Engine is a WordPress Plugin to connect WordPress with AI. We believe in Democratize AI. With this plugin, Your site can now chat, write poetry, create contents, videos, audio, solve problems, and maybe make you coffee. Please make sure you read the [disclaimer](https://rithemes.com/super-ai-engine/disclaimer/). For more information, check the official website of [Super AI Engine](https://rithemes.com/wordpress-plugins/super-ai-engine/).
 * Version:           1.0.0
 * Author:            Ri Themes
 * Author URI:        https://rithemes.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       super-ai-engine
 * Domain Path:       /languages
 */

namespace Super_Ai_Engine;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


include_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

include_once plugin_dir_path( __FILE__ ) . 'config.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-super-ai-engine-activator.php
 */
function activate_super_ai_engine() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-super-ai-engine-activator.php';
	Super_Ai_Engine_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-super-ai-engine-deactivator.php
 */
function deactivate_super_ai_engine() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-super-ai-engine-deactivator.php';
	Super_Ai_Engine_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_super_ai_engine' );
register_deactivation_hook( __FILE__, 'deactivate_super_ai_engine' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-super-ai-engine.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_super_ai_engine() {

	$plugin = new Super_Ai_Engine();
	$plugin->run();

}
run_super_ai_engine();

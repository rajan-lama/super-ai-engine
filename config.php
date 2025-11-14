<?php

/**
 * Global Constants.
 */

$plugin_version = '3.7.0';
// Useful global constants
sai_engine_define('SAI_ENGINE_PLUGIN', __DIR__ . '/SAI_ENGINE.php');
sai_engine_define('SAI_ENGINE_PLUGIN_VERSION', $plugin_version);
sai_engine_define('SAI_ENGINE_PLUGIN_DIR', __DIR__);
sai_engine_define('SAI_ENGINE_PLUGIN_URL', plugin_dir_url(__FILE__));
sai_engine_define('SAI_ENGINE_PLUGIN_BASENAME', plugin_basename(__DIR__ . '/SAI_ENGINE.php'));

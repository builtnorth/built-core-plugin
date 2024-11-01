<?php

/**
 * ------------------------------------------------------------------
 * Plugin: Built Core
 * ------------------------------------------------------------------
 *
 * @package BuiltCore
 * @since BuiltCore 1.0.0
 *
 * Plugin Name:       Built Core
 * Plugin URI:        
 * Description:       Core functionality for the site. Adds security and hardening features and cleans up some default functionality.
 * Version:           4.0.5
 * Author:            Built North
 * Author URI:        https://builtnorth.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       built-core-plugin
 * Domain Path:       /languages
 */

use WPBaseline;

// Don't load directly.
defined('ABSPATH') || exit;


/**
 * Define Global Constants
 * 
 * Use SemVer - https://semver.org
 */
define('BUILT_CORE_VERSION', '4.0.5');
define('BUILT_CORE_FILE', __FILE__);
define('BUILT_CORE_URL', plugin_dir_url(BUILT_CORE_FILE));
define('BUILT_CORE_PATH', plugin_dir_path(BUILT_CORE_FILE));


/**
 * Initialize WPBaseline
 */
if (class_exists('WPBaseline\App')) {
	$baseline = new WPBaseline\App;
	$baseline->boot();
}

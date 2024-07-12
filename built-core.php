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
 * Version:           2.1.1
 * Author:            Built North
 * Author URI:        https://builtnorth.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       built-core
 * Domain Path:       /languages
 */


/**
 * If called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Define plugin version.
 * @link https://semver.org
 */
define( 'BUILT_CORE_VERSION', '2.1.1' );

/**
 * Define global constants.
 */
define( 'BUILT_CORE_URL', plugin_dir_url( __FILE__ ) );
define( 'BUILT_CORE_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Require plugin files.
 */
require_once BUILT_CORE_PATH . 'inc/security.php'; // Security
require_once BUILT_CORE_PATH . 'inc/cleanup.php'; // Cleanup

/**
 * Run only if active theme has enabled:
 * add_theme_support('built-disable-comments');
 */
if (current_theme_supports('built-disable-comments')) {
    require_once BUILT_CORE_PATH . 'inc/disable-comments.php'; // Disable Comments
}
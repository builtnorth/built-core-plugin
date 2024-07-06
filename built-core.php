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
 * Version:           1.1.0
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
define( 'BUILT_CORE_VERSION', '1.1.0' );

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
 * Plugin Updage Checker
 * 
 * @link https://github.com/YahnisElsts/plugin-update-checker?tab=readme-ov-file#getting-started
 */
require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/builtnorth/built-core-plugin',
	__FILE__,
	'built-core'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

//Optional: If you're using a private repository, specify the access token like this:
//$myUpdateChecker->setAuthentication('your-token-here');
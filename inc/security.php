<?php
/**
 * ------------------------------------------------------------------
 * Functions: Security & Hardening
 * ------------------------------------------------------------------
 *
 * Further secure and harden WordPress
 * 
 * @package BuiltCore
 * @since BuiltCore 1.0.0
 *
 */

namespace BuiltCore\Security;


/**
 * If called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Remove WP version info from head and feeds
 */
add_filter('the_generator', __NAMESPACE__ . '\remove_wp_version_head_and_feeds');
function remove_wp_version_head_and_feeds() {
	return '';
}

/**
 * Remove WP version number from adm-n footer
 */
add_action( 'admin_menu', __NAMESPACE__ . '\remove_wp_version_footer' );
function remove_wp_version_footer() {
	remove_filter( 'update_footer', 'core_update_footer' );
}

/**
 * Remove WP version param from any enqueued scripts
 */
add_filter( 'style_loader_src', __NAMESPACE__ . '\remove_wp_version_files', 9999 );
add_filter( 'script_loader_src', __NAMESPACE__ . '\remove_wp_version_files', 9999 );
function remove_wp_version_files( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}

/**
 * Remove pings to self
 */
add_action( 'pre_ping', __NAMESPACE__ . '\no_self_ping' );
function no_self_ping( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link ) {
		if  ( 0 === strpos( $link, $home ) ) {
			unset($links[$l]);
		}
	}
}

/**
 * Disable XMLRPC
 */
add_action('init', __NAMESPACE__ . '\disable_xmlrpc');
function disable_xmlrpc() {
	add_filter( 'wp_xmlrpc_server_class', '__return_false' );
	add_filter('xmlrpc_enabled', '__return_false');
	add_filter( 'pre_update_option_enable_xmlrpc', '__return_false' );
	add_filter( 'pre_option_enable_xmlrpc', '__return_zero' );
}

/**
 * Remove xpinback header
 */
add_filter('wp_headers', __NAMESPACE__ . '\remove_x_pingback');
function remove_x_pingback($headers) {
	unset($headers['X-Pingback']);
	return $headers;
}

/**
 * Define Settings
 * 
 */
add_action('init', __NAMESPACE__ . '\define_settings');
function define_settings() {
	// Make WP use 'direct' dowload method for install/update
	if( !defined('FS_METHOD') ){
		define('FS_METHOD', 'direct');
	}
	// Block file editing
	if( !defined('DISALLOW_FILE_EDIT') ){
		define( 'DISALLOW_FILE_EDIT', true );
	}
}

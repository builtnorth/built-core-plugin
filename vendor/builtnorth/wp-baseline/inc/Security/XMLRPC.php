<?php

/**
 * ------------------------------------------------------------------
 * XMLRPC
 * ------------------------------------------------------------------
 *
 * Disable XMLRPC
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Security;

// Don't load directly.
defined('ABSPATH') || exit;

class XMLRPC
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{
		if ((bool) apply_filters('wpbaseline_disable_xmlrpc', true)) {
			add_filter('wp_xmlrpc_server_class', '__return_false');
			add_filter('xmlrpc_enabled', '__return_false');
			add_filter('pre_update_option_enable_xmlrpc', '__return_false');
			add_filter('pre_option_enable_xmlrpc', '__return_zero');
			add_filter('mod_rewrite_rules', [$this, 'block_xmlrpc_requests']);
			add_filter('wp_headers', [$this, 'remove_xmlrpc_headers']);
		}
	}

	/**
	 * Blocks XML-RPC requests
	 */
	public function block_xmlrpc_requests($rules)
	{
		return "
		# Block XML-RPC requests
		<Files xmlrpc.php>
			Order Deny,Allow
			Deny from all
		</Files>\n\n" . $rules;
	}

	/**
	 * Removes the X-Pingback header
	 */
	public function remove_xmlrpc_headers($headers)
	{
		unset($headers['X-Pingback']);
		return $headers;
	}
}

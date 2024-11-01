<?php

/**
 * ------------------------------------------------------------------
 * Pingbacks
 * ------------------------------------------------------------------
 *
 * Disable pingbacks
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Security;

// Don't load directly.
defined('ABSPATH') || exit;

class Pingbacks
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{
		add_action('pre_ping', [$this, 'no_self_ping']);
		add_filter('wp_headers', [$this, 'remove_x_pingback']);
	}

	/**
	 * Remove self pingbacks.
	 */
	public function no_self_ping(&$links)
	{
		$home = get_option('home');
		foreach ($links as $l => $link) {
			if (0 === strpos($link, $home)) {
				unset($links[$l]);
			}
		}
	}

	/**
	 * Remove X-Pingback header.
	 */
	public function remove_x_pingback($headers)
	{
		unset($headers['X-Pingback']);
		return $headers;
	}
}

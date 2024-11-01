<?php

/**
 * ------------------------------------------------------------------
 * AdminBar
 * ------------------------------------------------------------------
 *
 * Remove items from the admin bar
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Cleanup;

// Don't load directly.
defined('ABSPATH') || exit;

class AdminBar
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{
		add_filter('admin_bar_menu', [$this, 'replace_wordpress_howdy'], 9992);
		add_filter('admin_bar_menu', [$this, 'remove_admin_nodes'], 999);
	}

	/**
	 * Remove/Change "Howdy" text in admin menu
	 */
	public function replace_wordpress_howdy($wp_admin_bar)
	{
		$my_account = $wp_admin_bar->get_node('my-account');
		if (isset($my_account->title)) {
			// Apply a filter to allow customization of the "Howdy" text
			$howdy_text = apply_filters('wpbaseline_howdy_text', '');
			$newtitle = str_replace('Howdy, ', $howdy_text, $my_account->title);
			$wp_admin_bar->add_node(array(
				'id' => 'my-account',
				'title' => $newtitle,
			));
		}
	}



	/**
	 * Custom Admin Bar Menu
	 */
	public function remove_admin_nodes($wp_admin_bar)
	{
		// Check if the functionality should be enabled
		$enable_removal = apply_filters('wpbaseline_clean_admin_bar', true);

		// If the functionality is disabled, return the admin bar
		if (!$enable_removal) {
			return $wp_admin_bar;
		}

		// Default nodes to remove
		$default_nodes_to_remove = [
			'wp-logo',
			'search',
			'updates',
			'comments',
		];

		// Remove the default nodes
		foreach ($default_nodes_to_remove as $node) {
			$wp_admin_bar->remove_node($node);
		}

		return $wp_admin_bar;
	}
}

<?php

/**
 * ------------------------------------------------------------------
 * Dashboard
 * ------------------------------------------------------------------
 *
 * Remove unnecessary dashboard widgets
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Cleanup;

// Don't load directly.
defined('ABSPATH') || exit;

class Dashboard
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{
		add_action('wp_dashboard_setup', [$this, 'remove_dashboard_widgets']);
	}

	/**
	 * Remove dashboards
	 */
	public function remove_dashboard_widgets()
	{
		// Check if the removal of widgets should be enabled
		$enable_removal = apply_filters('wpbaseline_remove_dashboard_widgets', true);

		if (!$enable_removal) {
			return;
		}

		remove_action('welcome_panel', 'wp_welcome_panel');
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
		remove_meta_box('dashboard_primary', 'dashboard', 'side');
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
		remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
		remove_meta_box('dashboard_secondary', 'dashboard', 'side');
		remove_meta_box('dashboard_activity', 'dashboard', 'normal');
		// remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
	}
}

<?php

/**
 * ------------------------------------------------------------------
 * Mail
 * ------------------------------------------------------------------
 *
 * Customize the email sent from WordPress
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Cleanup;

// Don't load directly.
defined('ABSPATH') || exit;

class Mail
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{

		// Check if the removal of emails should be enabled
		$enable_removal = apply_filters('wpbaseline_disable_update_emails', true);

		if (!$enable_removal) {
			return;
		}

		add_filter('wp_mail_from_name', [$this, 'mail_from_name']);
		//add_filter('wp_mail_from', [$this, 'mail_from_email']);
		add_filter('auto_core_update_send_email', [$this, 'disable_auto_update_emails']);
		add_filter('auto_plugin_update_send_email', [$this, 'disable_auto_update_emails']);
		add_filter('auto_theme_update_send_email', [$this, 'disable_auto_update_emails']);
	}

	/**
	 * Change WP Mail from name
	 */
	public function mail_from_name()
	{
		return get_option("blogname");
	}

	/**
	 * Change WP Mail from email address
	 */
	// public function mail_from_email()
	// {
	// 	return get_option("admin_email");
	// }

	/**
	 * Disable auto update emails
	 */
	public function disable_auto_update_emails()
	{
		return false;
	}
}

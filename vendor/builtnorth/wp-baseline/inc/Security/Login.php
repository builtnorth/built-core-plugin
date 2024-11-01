<?php

/**
 * ------------------------------------------------------------------
 * Login
 * ------------------------------------------------------------------
 *
 * Enhance login security
 *
 * @package WPBaseline
 * @since 2.1.0
 */

namespace WPBaseline\Security;

// Don't load directly.
defined('ABSPATH') || exit;

class Login
{
	/**
	 * Initialize the class
	 */
	public function init()
	{
		if ((bool) apply_filters('wpbaseline_login_security', true)) {
			add_filter('authenticate', [$this, 'prevent_username_login'], 30, 3);
			add_filter('login_errors', [$this, 'generic_login_error']);
			add_action('login_enqueue_scripts', [$this, 'disable_autocomplete']);
		}
	}

	/**
	 * Prevents username login
	 */
	public function prevent_username_login($user, $username, $password)
	{
		if (!empty($username) && is_email($username)) {
			return $user;
		}
		return new \WP_Error('invalid_email', __('Please use your email address to login.', 'wp-baseline'));
	}

	/**
	 * Returns a generic login error message
	 */
	public function generic_login_error()
	{
		return __('The email address or password you entered is incorrect.', 'wp-baseline');
	}

	/**
	 * Disables autocomplete for login fields
	 */
	public function disable_autocomplete()
	{
		echo
		'<script>
            document.getElementById("user_login").autocomplete = "off";
            document.getElementById("user_pass").autocomplete = "off";
        </script>';
	}
}

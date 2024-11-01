<?php

/**
 * ------------------------------------------------------------------
 *  Rest API
 * ------------------------------------------------------------------
 *
 * Restricts access to the REST API
 *
 * @package WPBaseline
 * @since 1.0.0
 */

namespace WPBaseline\Security;

defined('ABSPATH') || exit;

class RestAPI
{

	/**
	 * Initialize the class
	 */
	public function init()
	{

		if ((bool) apply_filters('wpbaseline_disable_user_rest_endpoints', true)) {
			// Remove users endpoint for non-authenticated users
			add_filter('rest_endpoints', [$this, 'restrict_user_endpoints']);

			// Optionally disable the users endpoint completely
			if ((bool) apply_filters('wpbaseline_disable_user_rest_endpoints_completely', false)) {
				add_filter('rest_endpoints', [$this, 'disable_user_endpoints_completely']);
			}
		}
	}

	/**
	 * Restricts access to the users endpoint
	 */
	public function restrict_user_endpoints($endpoints)
	{
		// Check if user has appropriate capabilities
		if (!current_user_can('list_users')) {
			if (isset($endpoints['/wp/v2/users'])) {
				unset($endpoints['/wp/v2/users']);
			}
			if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
				unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
			}
		}
		return $endpoints;
	}

	/**	
	 * Completely remove user endpoints regardless of authentication
	 */
	public function disable_user_endpoints_completely($endpoints)
	{
		unset($endpoints['/wp/v2/users']);
		unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
		return $endpoints;
	}
}

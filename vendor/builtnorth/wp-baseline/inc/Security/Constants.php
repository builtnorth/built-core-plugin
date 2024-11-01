<?php

/**
 * ------------------------------------------------------------------
 * Constants
 * ------------------------------------------------------------------
 *
 * Define settings for security
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Security;

// Don't load directly.
defined('ABSPATH') || exit;


class Constants
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{
		add_action('init', [$this, 'define_constants']);
	}

	/**
	 * Define constants.
	 */
	public function define_constants()
	{
		if (!defined('FS_METHOD')) {
			define('FS_METHOD', 'direct');
		}
		if (!defined('DISALLOW_FILE_EDIT')) {
			define('DISALLOW_FILE_EDIT', true);
		}
	}
}

<?php

/**
 * ------------------------------------------------------------------
 * Version
 * ------------------------------------------------------------------
 *
 * Remove version information from the WordPress version header, feeds, and files.
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Security;

// Don't load directly.
defined('ABSPATH') || exit;

class Version
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{
		add_filter('the_generator', [$this, 'remove_wp_version_head_and_feeds']);
		add_action('admin_menu', [$this, 'remove_wp_version_footer'], 9999);
		add_filter('style_loader_src', [$this, 'replace_wp_version_in_files'], 9999);
		add_filter('script_loader_src', [$this, 'replace_wp_version_in_files'], 9999);
	}

	/**
	 * Remove the WordPress version from the head and feeds.
	 */
	public function remove_wp_version_head_and_feeds()
	{
		return '';
	}

	/**
	 * Remove the WordPress version from the footer.
	 */
	public function remove_wp_version_footer()
	{
		add_filter('admin_footer_text', '__return_empty_string', 11);
		add_filter('update_footer', '__return_empty_string', 11);
	}

	/**
	 * Replace the WordPress version in the files.
	 */
	public function replace_wp_version_in_files($src)
	{
		if (strpos($src, 'ver=')) {
			$version = $this->get_query_arg_value('ver', $src);
			if ($version === get_bloginfo('version')) {
				$src = remove_query_arg('ver', $src);
				$src = add_query_arg('ver', $this->get_asset_version(), $src);
			}
		}
		return $src;
	}

	/**
	 * Get the query argument value.
	 */
	private function get_query_arg_value($arg, $url)
	{
		$parts = parse_url($url);
		if (!isset($parts['query'])) {
			return null;
		}
		parse_str($parts['query'], $query);
		return isset($query[$arg]) ? $query[$arg] : null;
	}

	/**
	 * Get the asset version.
	 */
	private function get_asset_version()
	{
		// Constant defined by the theme or plugin
		$asset_version_constant = apply_filters('wpbaseline_asset_version_constant', '');
		if (defined($asset_version_constant)) {
			return constant($asset_version_constant);
		}
		// File modified time from theme
		$theme_file = get_template_directory() . '/style.css';
		if (file_exists($theme_file)) {
			return filemtime($theme_file);
		}
		// Default to today's date
		return date('Ymd');
	}
}

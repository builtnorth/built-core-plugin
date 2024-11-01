<?php

/**
 * ------------------------------------------------------------------
 * Emoji
 * ------------------------------------------------------------------
 *
 * Remove emoji support
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Cleanup;

// Don't load directly.
defined('ABSPATH') || exit;


class Emoji
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{

		// Check if the removal of widgets should be enabled
		$enable_removal = apply_filters('wpbaseline_disable_emojis', true);

		if (!$enable_removal) {
			return;
		}

		// Remove actions
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action('admin_print_styles', 'print_emoji_styles');
		remove_action('wp_footer', 'wp_print_emoji_detection_script');
		remove_action('wp_head', 'wp_print_emoji', 7);

		// Remove filters
		remove_filter('the_content_feed', 'wp_staticize_emoji');
		remove_filter('comment_text_rss', 'wp_staticize_emoji');
		remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

		// Disable from TinyMCE editor
		add_filter('tiny_mce_plugins', [$this, 'disable_emojis_tinymce']);

		// Remove emoji CDN hostname from DNS prefetching hints
		add_filter('wp_resource_hints', [$this, 'disable_emojis_remove_dns_prefetch'], 10, 2);

		// Finally, disable it from the database
		update_option('use_smilies', false);
	}

	/**
	 * Disable tinyMCE emojis
	 */
	public function disable_emojis_tinymce($plugins)
	{
		return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : [];
	}

	/**
	 * Remove emoji CDN hostname from DNS prefetching hints.
	 */
	public function disable_emojis_remove_dns_prefetch($urls, $relation_type)
	{
		if ('dns-prefetch' === $relation_type) {
			// This filter is documented in wp-includes/formatting.php
			$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
			$urls = array_diff($urls, [$emoji_svg_url]);
		}
		return $urls;
	}
}

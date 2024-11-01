<?php

/**
 * ------------------------------------------------------------------
 * Widgets
 * ------------------------------------------------------------------
 *
 * Remove default widgets
 */

namespace WPBaseline\Cleanup;

// Don't load directly.
defined('ABSPATH') || exit;

class Widgets
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{

		// Check if the removal of widgets should be enabled
		$enable_removal = apply_filters('wpbaseline_remove_widgets', true);

		if (!$enable_removal) {
			return;
		}

		add_action('widgets_init', [$this, 'unregister_widgets']);
		add_action('init', [$this, 'remove_widgets_theme_support'], 11);
		add_action('after_setup_theme', [$this, 'remove_widgets_theme_support']);
	}


	/**
	 * Unregister all widgets
	 */
	public function unregister_widgets()
	{
		unregister_widget('WP_Widget_Archives');
		unregister_widget('WP_Widget_Calendar');
		unregister_widget('WP_Widget_Categories');
		unregister_widget('WP_Widget_Custom_HTML');
		unregister_widget('WP_Widget_Links');
		unregister_widget('WP_Widget_Meta');
		unregister_widget('WP_Widget_Media_Audio');
		unregister_widget('WP_Widget_Media_Gallery');
		unregister_widget('WP_Widget_Media_Video');
		unregister_widget('WP_Widget_Media_Image');
		unregister_widget('WP_Nav_Menu_Widget');
		unregister_widget('WP_Widget_Pages');
		unregister_widget('WP_Widget_Recent_Posts');
		unregister_widget('WP_Widget_Recent_Comments');
		unregister_widget('WP_Widget_RSS');
		unregister_widget('WP_Widget_Search');
		unregister_widget('WP_Widget_Tag_Cloud');
		unregister_widget('WP_Widget_Text');
	}

	/**
	 * Remove widgets from block editor
	 */
	public function remove_widgets_theme_support()
	{
		remove_theme_support('widgets-block-editor');
		add_filter('use_widgets_block_editor', '__return_false');
		add_filter('gutenberg_use_widgets_block_editor', '__return_false', 100);
	}
}

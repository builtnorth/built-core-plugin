<?php

/**
 * ------------------------------------------------------------------
 * Comment Filters
 * ------------------------------------------------------------------
 *
 * Disable comments and remove related filters
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Comments;

class Filters
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{
		add_filter('comment_notification_recipients', [$this, 'disable_comment_notifications'], 10, 2);
		add_filter('rest_endpoints', [$this, 'disable_comment_rest_endpoints']);
		add_filter('comment_form_defaults', [$this, 'remove_comment_form']);
		add_filter('admin_bar_menu', [$this, 'adjust_admin_bar'], 999);
		add_filter('manage_pages_columns', [$this, 'remove_pages_count_columns']);
		add_filter('manage_posts_columns', [$this, 'remove_pages_count_columns']);
	}

	/**
	 * Disable comment notifications.
	 */
	public function disable_comment_notifications($notify, $comment_id)
	{
		return false;
	}

	/**
	 * Disable comment REST endpoints.
	 */
	public function disable_comment_rest_endpoints($endpoints)
	{
		if (isset($endpoints['/wp/v2/comments'])) {
			unset($endpoints['/wp/v2/comments']);
		}
		if (isset($endpoints['/wp/v2/comments/(?P<id>[\d]+)'])) {
			unset($endpoints['/wp/v2/comments/(?P<id>[\d]+)']);
		}
		return $endpoints;
	}

	/**
	 * Remove the comment form.
	 */
	public function remove_comment_form($defaults)
	{
		$defaults['comment_form'] = null;
		return $defaults;
	}

	/**
	 * Adjust the admin bar.
	 */
	public function adjust_admin_bar($wp_toolbar)
	{
		$wp_toolbar->remove_node('comments');
		return $wp_toolbar;
	}

	/**
	 * Remove the comments column from the pages and posts lists.
	 */
	public function remove_pages_count_columns($defaults)
	{
		unset($defaults['comments']);
		return $defaults;
	}
}

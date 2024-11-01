<?php

/**
 * ------------------------------------------------------------------
 * Comment Actions
 * ------------------------------------------------------------------
 *
 * Disable comments and remove related actions
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Comments;

class Actions
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{
		add_action('init', [$this, 'disable_comments']);
		add_action('admin_menu', [$this, 'remove_dashboard_sections']);
		add_action('wp_before_admin_bar_render', [$this, 'hide_admin_toolbar_link']);
		add_action('init', [$this, 'disable_comment_feeds']);
		add_action('widgets_init', [$this, 'disable_comment_widgets']);
		add_action('wp_enqueue_scripts', [$this, 'disable_comment_assets'], 100);
		add_action('admin_enqueue_scripts', [$this, 'disable_comment_assets'], 100);
		add_action('wp_dashboard_setup', [$this, 'remove_dashboard_comments_widget']);
		add_action('admin_init', [$this, 'redirect_comments_page']);
		add_action('enqueue_block_editor_assets', [$this, 'remove_discussion_panel']);
	}

	/**
	 * Disable comments for all post types.
	 */
	public function disable_comments()
	{
		$post_types = get_post_types();
		foreach ($post_types as $post_type) {
			if (post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}

		$wpdb = $GLOBALS['wpdb'];
		$wpdb->query("UPDATE $wpdb->posts SET comment_status = 'closed'");

		add_filter('rest_allow_anonymous_comments', '__return_false');
		add_filter('comments_open', '__return_false', 20, 2);
		add_filter('pings_open', '__return_false', 20, 2);
	}

	/**
	 * Remove the comments menu page and submenu page.
	 */
	public function remove_dashboard_sections()
	{
		remove_menu_page('edit-comments.php');
		remove_submenu_page('options-general.php', 'options-discussion.php');
	}

	/**
	 * Hide the comments link from the admin toolbar.
	 */
	public function hide_admin_toolbar_link()
	{
		if (is_admin_bar_showing()) {
			remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
		}
	}

	/**
	 * Disable comment feeds.
	 */
	public function disable_comment_feeds()
	{
		add_filter('feed_links_show_comments_feed', '__return_false');
	}

	/**
	 * Disable comment widgets.
	 */
	public function disable_comment_widgets()
	{
		unregister_widget('WP_Widget_Recent_Comments');
	}

	/**
	 * Disable comment assets.
	 */
	public function disable_comment_assets()
	{
		wp_dequeue_script('comment-reply');
		wp_dequeue_style('wp-admin');
	}

	/**
	 * Remove the dashboard comments widget.
	 */
	public function remove_dashboard_comments_widget()
	{
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	}

	/**
	 * Redirect to the dashboard when accessing the comments page.
	 */
	public function redirect_comments_page()
	{
		global $pagenow;

		if ($pagenow === 'edit-comments.php') {
			wp_redirect(admin_url());
			exit;
		}
	}

	/**
	 * Remove the discussion panel from the block editor.
	 */
	public function remove_discussion_panel()
	{
		wp_add_inline_script(
			'wp-edit-post',
			'wp.domReady(function () {
                wp.data.dispatch("core/edit-post").removeEditorPanel("discussion-panel");
            });'
		);
	}
}

<?php
/**
 * ------------------------------------------------------------------
 * Disable Comments Functionality
 * ------------------------------------------------------------------
 *
 * Disables all commenting functionality
 * 
 * To disable comments, add this theme support to the active theme:
 * add_theme_support('built-disable-comments');
 *
 * @package BuiltStarter
 * @since BuiltStarter 2.1.1
 *
**/

namespace BuiltCore\DisableComments;

/**
 * If this file is called directly, abort.
 */
if (!defined('WPINC')) {
    die;
}

/**
 * Disable comments on the front end
 */
function disable_comments() {
    // Remove support for comments and trackbacks from all post types
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }

    // Close comments on all existing posts
    global $wpdb;
    $wpdb->query("UPDATE $wpdb->posts SET comment_status = 'closed'");

    // Disable the display of comments in the WP API
    add_filter('rest_allow_anonymous_comments', '__return_false');
    add_filter('comments_open', '__return_false', 20, 2);
    add_filter('pings_open', '__return_false', 20, 2);
}
add_action('init', __NAMESPACE__ . '\disable_comments');

/**
 * Remove comment-related sections from the admin dashboard
 */
function remove_dashboard_sections() {
    remove_menu_page('edit-comments.php');
    remove_submenu_page('options-general.php', 'options-discussion.php');
}
add_action('admin_menu', __NAMESPACE__ . '\remove_dashboard_sections');

/**
 * Hide the "Comments" link from the admin toolbar
 */
function hide_admin_toolbar_link() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('wp_before_admin_bar_render', __NAMESPACE__ . '\hide_admin_toolbar_link');

/**
 * Disable Comment Feeds
 */
function disable_comment_feeds() {
    add_filter('feed_links_show_comments_feed', '__return_false');
}
add_action('init', __NAMESPACE__ . '\disable_comment_feeds');

/**
 * Disable Comment-related Widgets
 */
function disable_comment_widgets() {
    unregister_widget('WP_Widget_Recent_Comments');
}
add_action('widgets_init', __NAMESPACE__ . '\disable_comment_widgets');

/**
 * Disable Comment-related JS and CSS
 */
function disable_comment_assets() {
    wp_dequeue_script('comment-reply');
    wp_dequeue_style('wp-admin');
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\disable_comment_assets', 100);
add_action('admin_enqueue_scripts', __NAMESPACE__ . '\disable_comment_assets', 100);

/**
 * Disable Comment Notifications
 */
function disable_comment_notifications($notify, $comment_id) {
    return false;
}
add_filter('comment_notification_recipients', __NAMESPACE__ . '\disable_comment_notifications', 10, 2);

/**
 * Remove Comments from Dashboard Widgets
 */
function remove_dashboard_comments_widget() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', __NAMESPACE__ . '\remove_dashboard_comments_widget');

/**
 * Disable Comment-related REST API Endpoints
 */
function disable_comment_rest_endpoints($endpoints) {
    if (isset($endpoints['/wp/v2/comments'])) {
        unset($endpoints['/wp/v2/comments']);
    }
    if (isset($endpoints['/wp/v2/comments/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/comments/(?P<id>[\d]+)']);
    }
    return $endpoints;
}
add_filter('rest_endpoints', __NAMESPACE__ . '\disable_comment_rest_endpoints');

/**
 * Remove Comment Form from the Theme Templates
 */
function remove_comment_form($defaults) {
    $defaults['comment_form'] = null;
    return $defaults;
}
add_filter('comment_form_defaults', __NAMESPACE__ . '\remove_comment_form');

/**
 * Redirect comments page to admin dashboard
 */
function redirect_comments_page() {
    global $pagenow;
    
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', __NAMESPACE__ . '\redirect_comments_page');

/**
 * Adjust Admin Bar
 */
function adjust_admin_bar($wp_toolbar) {
    $wp_toolbar->remove_node('comments');  // disable comments
    return $wp_toolbar;
}
add_filter('admin_bar_menu', __NAMESPACE__ . '\adjust_admin_bar', 999);
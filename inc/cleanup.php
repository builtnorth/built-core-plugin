<?php
/**
 * ------------------------------------------------------------------
 * Functions: Cleanup
 * ------------------------------------------------------------------
 *
 * Clean up WordPress and remove unneeded functionality
 *
 * @package BuiltCore
 * @since BuiltCore 1.0.0
 *
 */

namespace BuiltCore\Cleanup;


/**
 * If called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Remove/Change "Howdy" text in admin menu
 */
add_filter( 'admin_bar_menu', __NAMESPACE__ . '\replace_wordpress_howdy', 25 );
function replace_wordpress_howdy( $wp_admin_bar ) {
	$my_account = $wp_admin_bar->get_node('my-account');
	$newtext = str_replace( 'Howdy,', '', $my_account->title );
	$wp_admin_bar->add_node( array(
	'id' => 'my-account',
	'title' => $newtext,
	) );
}

/**
 * Remove the WP logo from the admin bar
 */
add_action('wp_before_admin_bar_render', __NAMESPACE__ . '\remove_wp_icon_admin_bar');
function remove_wp_icon_admin_bar(){
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu("wp-logo");
}

/**
 * Update login logo image
 */
add_action( 'login_head', __NAMESPACE__ . '\custom_login_logo', 100 );
function custom_login_logo() {
	if ( has_custom_logo() ) :
		$image = wp_get_attachment_image_src( get_option( 'site_logo' ), 'full' );
		?>
		<style type="text/css">
			.login h1 a {
				background-image: url(<?php echo esc_url( $image[0] ); ?>);
				background-repeat: no-repeat;
				background-size: contain;
				width: auto;
				height: 80px;
				margin-bottom: 30px;
			}
		</style>
		<?php
	endif;
}

/**
 * Update login logo link URL
 */
add_filter('login_headerurl', __NAMESPACE__ . '\update_login_logo_url');
function update_login_logo_url(){
    return home_url();
}

/**
 * Update login logo link title
 */
add_filter('login_headertext', __NAMESPACE__ . '\update_login_logo_text');
function update_login_logo_text(){
	return get_option("blogname");
}

 /**
  * Change WP Mail from name
  */
 add_filter('wp_mail_from_name', __NAMESPACE__ . '\mail_from_name');
 function mail_from_name($name) {
	return get_option("blogname");
 }

 /**
  * Change WP Mail from email address
  */
  add_filter('wp_mail_from', __NAMESPACE__ . '\mail_from_email');
  function mail_from_email($name) {
	return get_option("admin_email");
}

/**
 * Disable auto_core_update_send_email
 */
add_filter( 'auto_core_update_send_email', __NAMESPACE__ . '\auto_core_update_send_email');
function auto_core_update_send_email(){
	return false;
}

/**
 * Disable auto_plugin_update_send_email
 */
add_filter( 'auto_plugin_update_send_email', __NAMESPACE__ . '\auto_plugin_update_send_email');
function auto_plugin_update_send_email(){
	return false;
}

/**
 * Disable auto_theme_update_send_email
 */
add_filter( 'auto_theme_update_send_email', __NAMESPACE__ . '\auto_theme_update_send_email');
function auto_theme_update_send_email(){
	return false;
}


/**
 * Remove unnecessary code from wp_head
 */
add_action('init', __NAMESPACE__ . '\remove_actions_from_head');
function remove_actions_from_head() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'start_post_rel_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'adjacent_posts_rel_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}

/**
 * Unregister all widgets
 */
add_action('widgets_init', __NAMESPACE__ . '\unregister_widgets', 11);
function unregister_widgets() {
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
add_action( 'after_setup_theme', __NAMESPACE__ . '\remove_widgets_theme_support' );
function remove_widgets_theme_support() {
	remove_theme_support( 'widgets-block-editor' );
	add_filter( 'use_widgets_block_editor', '__return_false' );
    add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );
}

/**
 * Remove default meta boxes
*/
add_action( 'admin_menu', __NAMESPACE__ . '\remove_metaboxes' );
function remove_metaboxes() {
	remove_meta_box( 'commentstatusdiv' , 'page' , 'normal' );
	remove_meta_box( 'commentsdiv' , 'page' , 'normal' );
	remove_meta_box( 'authordiv' , 'page' , 'normal' );
}

/**
 * Remove dashboards
 */
add_action('admin_init', __NAMESPACE__ . '\remove_dashboards');
function remove_dashboards() {
	remove_action('welcome_panel', 'wp_welcome_panel');
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
}

/**
 * Remove emoji filter & action hooks
*/
add_action( 'init', __NAMESPACE__ . '\disable_emojis' );
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
 	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

}

/**
 * Disable tinyMCE emojis
 */
add_filter( 'tiny_mce_plugins', __NAMESPACE__ . '\disable_emojis_tinymce' );
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 */
add_filter( 'wp_resource_hints', __NAMESPACE__ . '\disable_emojis_remove_dns_prefetch', 10, 2 );
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
 if ( 'dns-prefetch' == $relation_type ) {
	//This filter is documented in wp-includes/formatting.php
	$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
	$urls = array_diff( $urls, array( $emoji_svg_url ) );
 }
 return $urls;
}

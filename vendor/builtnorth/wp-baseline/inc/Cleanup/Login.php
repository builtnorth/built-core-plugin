<?php

/**
 * ------------------------------------------------------------------
 * Login
 * ------------------------------------------------------------------
 *
 * Customize the login page
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\Cleanup;

// Don't load directly.
defined('ABSPATH') || exit;

class Login
{

	/**
	 * Initialize the class.
	 */
	public function init()
	{
		add_action('login_head', [$this, 'custom_login_logo'], 100);
		add_filter('login_headerurl', [$this, 'update_login_logo_url']);
		add_filter('login_headertext', [$this, 'update_login_logo_text']);
	}

	/**
	 * Update login logo image
	 */
	public function custom_login_logo()
	{
		if (has_custom_logo()) :
			$image = wp_get_attachment_image_src(get_option('site_logo'), 'full');
?>
			<style type="text/css">
				.login h1 a {
					background-image: url(<?php echo esc_url($image[0]); ?>);
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
	public function update_login_logo_url()
	{
		return home_url();
	}

	/**
	 * Update login logo link title
	 */
	public function update_login_logo_text()
	{
		return get_option("blogname");
	}
}

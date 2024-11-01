<?php

/**
 * ------------------------------------------------------------------
 * SVG Sanitization
 * ------------------------------------------------------------------
 * 
 * Sanitize SVG uploads.
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\SVG;

use enshrined\svgSanitize\Sanitizer;

class Sanitize
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{
		add_filter('wp_handle_upload_prefilter', [$this, 'sanitize_svg']);
	}

	/**
	 * Sanitize SVG uploads.
	 */
	public function sanitize_svg($file)
	{
		if ($file['type'] === 'image/svg+xml') {
			$sanitizer = new Sanitizer();
			$dirty_svg = file_get_contents($file['tmp_name']);
			$clean_svg = $sanitizer->sanitize($dirty_svg);

			if ($clean_svg === false) {
				$file['error'] = __('SVG file could not be sanitized.', 'built-wp-baseline');
			} else {
				file_put_contents($file['tmp_name'], $clean_svg);
			}
		}
		return $file;
	}
}

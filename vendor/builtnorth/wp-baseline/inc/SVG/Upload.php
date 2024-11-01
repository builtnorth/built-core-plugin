<?php

/**
 * ------------------------------------------------------------------
 * SVG Upload
 * ------------------------------------------------------------------
 *
 * Allow SVG uploads and fix the thumbnail display.
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline\SVG;

// Don't load directly.
defined('ABSPATH') || exit;

class Upload
{
	/**
	 * Initialize the class.
	 */
	public function init()
	{
		add_filter('upload_mimes', [$this, 'add_svg_mime_type']);
		add_filter('wp_check_filetype_and_ext', [$this, 'check_svg_filetype'], 10, 4);
		add_action('admin_head', [$this, 'fix_svg_thumbnail_display']);
	}

	/**
	 * Add SVG mime type.
	 */
	public function add_svg_mime_type($mimes)
	{
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Check SVG file type.
	 */
	public function check_svg_filetype($data, $file, $filename, $mimes)
	{
		$filetype = wp_check_filetype($filename, $mimes);
		return [
			'ext'             => $filetype['ext'],
			'type'            => $filetype['type'],
			'proper_filename' => $data['proper_filename']
		];
	}

	/**
	 * Fix SVG thumbnail display.
	 */
	public function fix_svg_thumbnail_display()
	{
		echo '<style type="text/css">
                .attachment-266x266, .thumbnail img {
                    width: 100% !important;
                    height: auto !important;
                }
              </style>';
	}
}

<?php

/**
 * ------------------------------------------------------------------
 * App
 * ------------------------------------------------------------------
 * 
 * Bootstrap all classes.
 *
 * @package WPBaseline
 * @since 2.0.0
 */

namespace WPBaseline;

use WPBaseline\Cleanup\Init as CleanupInit;
use WPBaseline\Comments\Init as CommentsInit;
use WPBaseline\Security\Init as SecurityInit;
use WPBaseline\SVG\Init as SVGInit;

// Don't load directly.
defined('ABSPATH') || exit;

class App
{
	/**
	 * Bootstrap all classes.
	 */
	public function boot()
	{
		// Initialize cleanup classes
		$cleanup = new CleanupInit();
		$cleanup->init();

		// Initialize comments classes
		$comments = new CommentsInit();
		$comments->init();

		// Initialize security classes
		$security = new SecurityInit();
		$security->init();

		// Initialize SVG classes
		$svg = new SVGInit();
		$svg->init();
	}
}

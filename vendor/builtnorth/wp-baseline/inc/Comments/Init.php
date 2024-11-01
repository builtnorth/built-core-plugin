<?php

/**
 * ------------------------------------------------------------------
 * Init
 * ------------------------------------------------------------------
 *
 * Initialize the cleanup classes
 *
 * @package WPBaseline
 * @since 1.0.0
 */

namespace WPBaseline\Comments;

use WPBaseline\Abstracts\AbstractInit;

// Don't load directly.
defined('ABSPATH') || exit;

class Init extends AbstractInit
{
	/**
	 * Get the namespace for the init class
	 */
	protected function getNamespace(): string
	{
		return __NAMESPACE__;
	}

	/**
	 * Get the classes to initialize
	 */
	protected function getClasses(): array
	{
		return [
			'Actions',
			'Filters',
		];
	}
}

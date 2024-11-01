<?php

/**
 * ------------------------------------------------------------------
 * Abstract Init
 * ------------------------------------------------------------------
 *
 * Abstract class for initializing classes.
 *
 * @package WPBaseline
 * @since 2.1.0
 */

namespace WPBaseline\Abstracts;

// Don't load directly.
defined('ABSPATH') || exit;

abstract class AbstractInit
{
	/**
	 * Initialize classes
	 */
	public function init()
	{
		$classes = $this->getClasses();

		foreach ($classes as $class) {
			$class_name = $this->getNamespace() . '\\' . $class;
			if (class_exists($class_name)) {
				$instance = new $class_name();
				if (method_exists($instance, 'init')) {
					$instance->init();
				}
			}
		}
	}

	/**
	 * Get the namespace for the init class
	 */
	protected function getNamespace(): string
	{
		return __NAMESPACE__;
	}

	/**
	 * Get array of class names to initialize
	 * @return string[]
	 */
	abstract protected function getClasses(): array;
}

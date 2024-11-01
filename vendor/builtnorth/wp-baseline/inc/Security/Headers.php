<?php

/**
 * ------------------------------------------------------------------
 * Headers
 * ------------------------------------------------------------------
 *
 * Implements security headers for WordPress.
 *
 * @package WPBaseline
 * @since 2.1.0
 */

namespace WPBaseline\Security;

// Don't load directly.
defined('ABSPATH') || exit;

class Headers
{
	/**
	 * Default security headers
	 *
	 * @var array
	 */
	private const SECURITY_HEADERS = [
		'X-Content-Type-Options' => 'nosniff',
		'X-Frame-Options' => 'SAMEORIGIN',
		'X-XSS-Protection' => '1; mode=block',
		'Referrer-Policy' => 'strict-origin-when-cross-origin',
		'Permissions-Policy' => 'geolocation=(), microphone=()',
		'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
	];

	/**
	 * Default Content Security Policy directives
	 *
	 * @var array
	 */
	private const CSP_DIRECTIVES = [
		'default-src'  => "'self'",
		'script-src'   => "'self' 'unsafe-inline' 'unsafe-eval' https: *.googleapis.com *.gstatic.com *.google.com *.google-analytics.com *.doubleclick.net *.wordpress.org *.wp.com",
		'style-src'    => "'self' 'unsafe-inline' https:",
		'img-src'      => "'self' data: https: *",
		'font-src'     => "'self' data: https:",
		'connect-src'  => "'self' https:",
		'media-src'    => "'self' https:",
		'object-src'   => "'none'",
		'frame-src'    => "'self' https:",
		'base-uri'     => "'self'",
		'form-action'  => "'self'",
	];

	/**
	 * Initialize security headers
	 */
	public function init(): void
	{
		// Check if security headers are enabled
		if (!(bool) apply_filters('wpbaseline_enable_security_headers', true)) {
			return;
		}

		// Apply security headers
		add_action('send_headers', [$this, 'apply_headers']);
	}

	/**
	 * Apply all security headers
	 */
	public function apply_headers(): void
	{
		// Set security headers	
		$this->set_security_headers();

		// Set CSP header
		$this->set_csp_header();
	}

	/**
	 * Set basic security headers
	 */
	private function set_security_headers(): void
	{
		// Apply security headers
		$headers = apply_filters('wpbaseline_security_headers', self::SECURITY_HEADERS);

		// Loop through headers and set them
		foreach ($headers as $name => $value) {
			header("$name: $value");
		}
	}

	/**
	 * Set Content Security Policy header
	 */
	private function set_csp_header(): void
	{
		// Check if headers have already been sent
		if (headers_sent()) {
			return;
		}

		// Get CSP directives
		$directives = apply_filters('wpbaseline_security_headers_csp', self::CSP_DIRECTIVES);

		// Build CSP header value
		$header_value = $this->build_csp_value($directives);

		// Set CSP header if value is not empty
		if (!empty($header_value)) {
			header("Content-Security-Policy: $header_value");
		}
	}

	/**
	 * Build CSP header value from directives
	 *
	 * @param array $directives CSP directives
	 * @return string Formatted CSP header value
	 */
	private function build_csp_value(array $directives): string
	{
		// Initialize parts array
		$parts = [];

		// Loop through directives and build parts
		foreach ($directives as $directive => $value) {
			$parts[] = "$directive $value";
		}

		// Return parts as a string separated by semicolons
		return implode('; ', $parts);
	}
}

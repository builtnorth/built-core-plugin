# WP Baseline

WP Baseline is a Composer package that provides baseline functionality for WordPress. Some of the functionality includes:

-   Cleanup of unnecessary WordPress features
-   Enhanced security measures
-   SVG upload support with sanitization
-   Cleanup of the admin dashboard

## Requirements

-   PHP >= 8
-   WordPress >= 6

## Installation & Usage

This library is meant to be dropped into a theme or plugin via composer.

1. In your WordPress project directory, run: `composer require builtnorth/wp-baseline`.
2. In your main plugin file or theme's functions.php, add:

```php
use WPBaseline;

if (class_exists('WPBaseline\App')) {
    $baseline = new WPBaseline\App;
    $baseline->boot();
}
```

## Features

### Disable Comments

Comments remain enabled by default. To disable them, set this filter to return true:

```php
add_filter('wpbaseline_disable_comments', '__return_true');
```

### Howdy Text

By default the "Howdy" text is removed from the admin bar. You can customize this and add your own text using the following filter:

```php
add_filter('wpbaseline_howdy_text', function ($text) {
    return 'Hey,';
});
```

### Admin Bar

By default the WP logo, search, and updates nodes are removed from the admin bar. They can be re-enabled using the following filter:

```php
add_filter('wpbaseline_clean_admin_bar', '__return_false');
```

### Dashboard Widgets

Most core dashboard widgets are removed. They can be re-enabled using the following filter:

```php
add_filter('wpbaseline_remove_dashboard_widgets', '__return_false');
```

### Emojis

Emojis are disabled. They can be re-enabled using the following filter:

```php
add_filter('wpbaseline_disable_emojis', '__return_false');
```

### Auto Update Emails

Auto update emails are disabled. Additionally, the from name in the email is customized based on the site name. This functionality can be reverted back to the default by using the filter:

```php
add_filter('wpbaseline_disable_update_emails', '__return_false');
```

### Asset Version Numbering

Wordpress adds a version query argument to all enqueued assets by default. This exposes the version number, which can be a security risk. WP Baseline replaces the version number with `filemtime` of the theme's style.css file by default with a fallback to `date('Ymd')`. However, you can set a custom version by defining a constant in your theme or plugin:

```php
define('YOUR_THEME_VERSION', '1.2.9');
add_filter('wpbaseline_asset_version_constant', function () {
    return 'YOUR_THEME_VERSION';
});
```

### Security Headers

WP Baseline implements security headers by default for enhanced security. These include:

-   Content Security Policy (CSP)
-   X-Content-Type-Options
-   X-Frame-Options
-   And more...

To disable all security headers:

```php
add_filter('wpbaseline_enable_security_headers', '__return_false');
```

To modify specific headers or CSP rules, use these filters:

```php
// Modify security headers
add_filter('wpbaseline_security_headers', function($headers) {
    // Customize headers
    $headers['X-Frame-Options'] = 'DENY';
    return $headers;
});
```

### Login Security

The following items have been added to enhance login security:

-   Prevent username login
-   Returnsa generic login error message
-   Disable autocomplete for login fields

To disable login security enhancements, use the following filter:

```php
add_filter('wpbaseline_login_security', '__return_false');
```

### REST API User Endpoints

REST API user endpoints are restricted to users with the `list_users` capability by default. To disable this restriction and make the user endpoint publicly accessible again use this filter:

```php
add_filter('wpbaseline_disable_user_rest_endpoints', '__return_false');
```

### XMLRPC

XMLRPC is disabled by default. To re-enable it, use the following filter:

```php
add_filter('wpbaseline_disable_xmlrpc', '__return_false');
```

### SVG Support

Adds support for SVG uploads. SVGs are automatically sanitized upon upload using the [enshrined/svg-sanitize](https://github.com/darylldoyle/svg-sanitizer) library for security to remove potentially malicious content.

To disable SVG support, use the following filter:

```php
add_filter('wpbaseline_enable_svg_support', '__return_false');
```

## Disclaimer

This software is provided "as is", without warranty of any kind, express or implied, including but not limited to the warranties of merchantability, fitness for a particular purpose and noninfringement. In no event shall the authors or copyright holders be liable for any claim, damages or other liability, whether in an action of contract, tort or otherwise, arising from, out of or in connection with the software or the use or other dealings in the software.

Use of this library is at your own risk. The authors and contributors of this project are not responsible for any damage to your website or any loss of data that may result from the use of this library.

While we strive to keep this library up-to-date and secure, we make no guarantees about its performance, reliability, or suitability for any particular purpose. Users are advised to thoroughly test the library in a safe environment before deploying it to a live site.

By using this library, you acknowledge that you have read this disclaimer and agree to its terms.

# Built Core Plugin

See [wp-baseline](https://github.com/builtnorth/wp-baseline) instead. Same functionality to this plugin, but it's a drop-in composer package instead.

Contains core functionality for WordPress websites. Adds security and hardening features and cleans up some default functionality.

### Requirements:

-   PHP >= 7.0
-   WordPress >= 6.4

## Installation & Usage

Clone or download this repository into /plugins or /mu-plugins and activate the plugin.

## Disable Comments

This plugin includes optional functionality to completely disable comments. To enable this functionality, add `add_theme_support('built-disable-comments');` to your functions.php file.

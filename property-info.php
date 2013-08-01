<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package   PropertyInfo
 * @author    Jonathan Rivera <jrivera@picernefl.com>
 * @license   GPL-2.0+
 * @link      http://www.picernerealestategroup.com
 * @copyright 2013 Picerne Real Estate Group
 *
 * @wordpress-plugin
 * Plugin Name: Property Information
 * Plugin URI:  http://www.picernerealestategroup.com
 * Description: Stores your Property Information in your WordPress Database to make the information available to your theme.
 * Version:     1.0.0
 * Author:      Jonathan Rivera
 * Author URI:  Jonathan Rivera
 * Text Domain: property-info-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// TODO: replace `class-plugin-name.php` with the name of the actual plugin's class file
require_once( plugin_dir_path( __FILE__ ) . 'class-property-info.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
// TODO: replace PluginName with the name of the plugin defined in `class-plugin-name.php`
register_activation_hook( __FILE__, array( 'PropertyInfo', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'PropertyInfo', 'deactivate' ) );

// TODO: replace PluginName with the name of the plugin defined in `class-plugin-name.php`
PropertyInfo::get_instance();
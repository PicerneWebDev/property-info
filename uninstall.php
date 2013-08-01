<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   PropertyInfo
 * @author    Jonathan Rivera <jrivera@picernefl.com>
 * @license   
 * @link      
 * @copyright 2013 Picerne Real Estate Group
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// TODO: Define uninstall functionality here
<?php
/**
 * Plugin Name: OS Imagen Header
 * Plugin URI: http://www.opensistemas.com/
 * Description: Widget que muestra una imagen con un cuadro de texto y un link.
 * Version: 1.0
 * Author: Marta Oliver
 * Author URI: http://www.opensistemas.com/
 * Text Domain: os_image_widget
 */


// Exit if accessed directly.
if ( ! defined('ABSPATH')) {
	exit;
}

/**
 * Main plugin instance.
 *
 * @since 4.0.0
 * @type OS_Image_Widget $os_image_widget
 */
global $os_image_widget;

if ( ! defined('SIW_DIR')) {
	/**
	 * Plugin directory path.
	 *
	 * @since 4.0.0
	 * @type string SIW_DIR
	 */
	define('SIW_DIR', plugin_dir_path( __FILE__ ));
}

/**
 * Check if the installed version of WordPress supports the new media manager.
 *
 * @since 3.0.0
 */
function is_os_image_widget_legacy() {
	/**
	 * Whether the installed version of WordPress supports the new media manager.
	 *
	 * @since 4.0.0
	 *
	 * @param bool $is_legacy
	 */
	return apply_filters('is_os_image_widget_legacy', version_compare( get_bloginfo('version'), '3.4.2', '<='));
}

/**
 * Include functions and libraries.
 */
require_once( SIW_DIR . 'includes/class_os_image_widget.php');
require_once( SIW_DIR . 'includes/class_os_image_widget_legacy.php');
require_once( SIW_DIR . 'includes/class_os_image_widget_plugin.php');
require_once( SIW_DIR . 'includes/class_os_image_widget_template_loader.php');

/**
 * Deprecated main plugin class.
 *
 * @since      3.0.0
 * @deprecated 4.0.0
 */
class OS_Image_Widget_Loader extends OS_Image_Widget_Plugin {}

// Initialize and load the plugin.
$os_image_widget = new OS_Image_Widget_Plugin();
add_action('plugins_loaded', array($os_image_widget, 'load'));


function restrict_mime($mimes) {

	$mimes = array(
		'png' => 'image/png',
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif' => 'image/gif',
	);
	
	return $mimes;
}
//add_filter('upload_mimes','restrict_mime');
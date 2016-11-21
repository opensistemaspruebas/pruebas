<?php
/*
Plugin Name: OS Redes Sociales Footer
Plugin URI: http://www.opensistemas.com
Description: Página en admin para redes sociales footer
Version: 1.0
Author: Roberto Ojosnegros 
Author email: ropavon@opensistemas.com
Text Domain: os_redes_plugin
License: GPL2
*/

if (!class_exists('OSRedesFooter')) :

	class OSRedesFooter {


		function __construct () {
			add_action('admin_menu', array(&$this, 'os_redes_menu'));
			add_action('plugins_loaded', array(&$this, 'load_text_domain'), 10);
        }

        // Selecciona Dominio para la traducción
        function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_redes_plugin', false, $plugin_dir . "/languages");
        }

		function os_redes_menu(){
		   	add_options_page(__('Redes sociales Footer', 'os_redes_plugin'), __('Redes sociales Footer','os_redes_plugin'), 'manage_options', 'os-redes-menu-footer', array(&$this,'os_redes_options_footer'));
		   	//call register settings function
			add_action( 'admin_init', array(&$this, 'register_social_settings' ));

		}

		function os_redes_options_footer(){
	    	include('admin/os_redes_footer_admin.php');
		}

		function register_social_settings() {
			// Redes sociales footer
		
			register_setting( 'os-social-footer', 'twitter-url' );
			register_setting( 'os-social-footer', 'youtube-url' );
			register_setting( 'os-social-footer', 'facebook-url' );

		}

	}

	$OSRedesFooter = new OSRedesFooter();

endif;

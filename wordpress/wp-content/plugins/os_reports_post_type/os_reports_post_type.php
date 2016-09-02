<?php
/**
 * Plugin Name: OS Reports Post Type
 * Plugin URI: http://www.opensistemas.com/
 * Description: Crea el tipo de contenido "Publicación".
 * Version: 1.0
 * Author: Marta Oliver
 * Author URI: http://www.opensistemas.com/
 * Text Domain: os_reports_post_type
 */


if (!class_exists('Report_Post_Type')) :
  
   class Report_Post_Type {   
        
        var $post_type = "publicacion";
        
        function __construct() {
            add_action('init', array(&$this, 'create_post_type'));
            add_action('add_meta_boxes', array(&$this, 'meta_boxes_add'));
            add_action('save_post', array(&$this, "meta_boxes_save"));
            add_action('admin_print_styles', array(&$this,'register_admin_styles'));
            add_action('admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));
            add_action('plugins_loaded', array(&$this, 'load_text_domain'), 10);
        }


        // Selecciona el dominio para la traducción
        function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_reports_post_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Publicaciones', 'os_reports_post_type'),
                    'singular_name' => __('Publicación', 'os_reports_post_type'),
                    'add_new' => __('Añadir nueva', 'os_reports_post_type'),
                    'add_new_item' => __('Añadir nueva publicación', 'os_reports_post_type'),
                    'new_item' => __('Nueva publicación', 'os_reports_post_type'),
                    'edit_item' => __('Editar publicación', 'os_reports_post_type'),
                    'view_item' => __('Ver publicación', 'os_reports_post_type'),
                    'parent_item_colon' => __(' ', 'os_reports_post_type'),
                    'search_items' => __('Buscar publicaciones', 'os_reports_post_type'),
                    'not_found' => __('No se han encontrado publicaciones', 'os_reports_post_type'),
                    'not_found_in_trash' => __('No se han encontrado publicaciones en la papelera', 'os_reports_post_type'),
                    'menu_name' => __('Publicaciones', 'os_reports_post_type')
                ),
                'capability_type' => 'post',
                'description' => __("Este tipo de entrada recoge diferentes publicaciones"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'publicacion'),
                'menu_icon' =>  'dashicons-format-aside',
                'supports' => array("title")
            ));
        }

    }

    $report_post_type = new Report_Post_Type();

endif;
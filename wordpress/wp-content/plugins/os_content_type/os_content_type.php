<?php

/*
    Plugin Name: OS Content Type
    Plugin URI: http://www.opensistemas.com/
    Description: Crea el tipo de contenido 'Contenido'
    Version: 1.0
    Author: Marta Oliver
    Author Email: moliver@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: os_content_type
    License: GPLv2 
*/

if (!class_exists('ContentCustomType')) :
  
   class ContentCustomType {   
        
        var $post_type = "content";
        
        function __construct() {
            add_action('init', array(&$this, 'create_post_type'));
            add_action('admin_print_styles', array(&$this,'register_admin_styles'));
            add_action('plugins_loaded', array(&$this, 'load_text_domain'), 10);
        }


        // Selecciona el dominio para la traducción
        function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_content_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Contents', 'os_content_type'),
                    'singular_name' => __('Contenido', 'os_content_type'),
                    'add_new' => __('Add new', 'os_content_type'),
                    'add_new_item' => __('Add new content', 'os_content_type'),
                    'new_item' => __('New content', 'os_content_type'),
                    'edit_item' => __('Edit content', 'os_content_type'),
                    'view_item' => __('View content', 'os_content_type'),
                    'parent_item_colon' => __(' ', 'os_content_type'),
                    'search_items' => __('Search contents', 'os_content_type'),
                    'not_found' => __('No contents found', 'os_content_type'),
                    'not_found_in_trash' => __('No contents found in trash', 'os_content_type'),
                    'menu_name' => __('Contents', 'os_content_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different contents", "os_content_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Content'),
                'menu_icon' =>  'dashicons-exerpt-view',
                'supports' => array("title", "editor")
            ));
        }


        function register_admin_styles(){
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_style('content-type-css', plugin_dir_url(__FILE__) . 'css/os_content_type.css');               
            }
        }

    }

    $osContent = new ContentCustomType();


endif;


function my_attachments($attachments) {

    $fields = array(
        array(
          'name' => 'title',
          'type' => 'text',
          'label' => __('Title', 'os_content_type'),
          'default' => 'title',
        ),
    );

    $args = array(
        'label' => __('Attachments', 'os_content_type'),
        'post_type' => array('content'),
        'position' => 'side',
        'priority' => 'low',
        'filetype' => array("application", "video"),
        'note' => __('Attach files here', 'os_content_type'),
        'append' => true,
        'button_text' => __('Attach Files', 'os_content_type'),
        'modal_text' => __('Attach', 'os_content_type'),
        'router' => 'browse',
        'post_parent' => false,
        'fields' => $fields
    );
    $attachments->register('my_attachments', $args);
}
add_action('attachments_register', 'my_attachments');
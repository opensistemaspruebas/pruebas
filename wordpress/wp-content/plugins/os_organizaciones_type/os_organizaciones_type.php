<?php
/*
Plugin Name: OS Organizaciones Type
Plugin URI: http://www.opensistemas.com
Description: Crea el tipo de contenido 'Organizaciones'
Version: 1.0
Author: Roberto Moreno 
Author URI: http://www.opensistemas.com/
Author email: rmoreno@opensistemas.com
Text Domain: os_organizaciones_type
License: GPL2
*/


if (!class_exists('OrganizacionesCustomType')) :
  
   class OrganizacionesCustomType extends OrganizacionesPartnersCustomType{   
       
var $post_type = "organizaciones";
        
        function __construct() {
        	parent::__construct();
            add_action('init', array(&$this, 'create_post_type'));
            add_action('admin_enqueue_scripts', 'register_admin_scripts');
        }

         function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Organizaciones', 'os_organizaciones_type'),
                    'singular_name' => __('Organización', 'os_organizaciones_type'),
                    'add_new' => __('Añadir nueva Organización', 'os_organizaciones_type'),
                    'add_new_item' => __('Añadir nueva Organización', 'os_organizaciones_type'),
                    'new_item' => __('Nueva Organización', 'os_organizaciones_type'),
                    'edit_item' => __('Editar Organización', 'os_organizaciones_type'),
                    'view_item' => __('Ver Organización', 'os_organizaciones_type'),
                    'parent_item_colon' => __(' ', 'os_organizaciones_type'),
                    'search_items' => __('Buscar Organizaciones', 'os_organizaciones_type'),
                    'not_found' => __('No se han encontrado organizaciones', 'os_organizaciones_type'),
                    'not_found_in_trash' => __('No se han encontrado organizaciones en la papelera', 'os_organizaciones_type'),
                    'menu_name' => __('Organizaciones', 'os_organizaciones_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different Organizaciones", "os_organizaciones_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Organizaciones'),
                'menu_icon' =>  'dashicons-star-empty',
                'supports' => array("title")
            ));
        }



    }

    $osOrganizaciones = new OrganizacionesCustomType();


endif;

<?php
/*
Plugin Name: OS Partner Type
Plugin URI: http://www.opensistemas.com
Description: Crea el tipo de contenido 'Partner'
Version: 1.0
Author: Roberto Moreno 
Author URI: http://www.opensistemas.com/
Author email: rmoreno@opensistemas.com
Text Domain: os_partner_type
License: GPL2
*/


if (!class_exists('PartnerCustomType')) :
  
   class PartnerCustomType extends MiembrosPartnersCustomType{   
       
var $post_type = "partners";
        
        function __construct() {
            parent::__construct();
            add_action('init', array(&$this, 'create_post_type'));
            add_action('admin_enqueue_scripts', 'register_admin_scripts');
        }

         function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Partners', 'os_partner_type'),
                    'singular_name' => __('Partner', 'os_partner_type'),
                    'add_new' => __('Añadir nuevo Partner', 'os_partner_type'),
                    'add_new_item' => __('Añadir nuevo Partner', 'os_partner_type'),
                    'new_item' => __('Nuevo Partner', 'os_partner_type'),
                    'edit_item' => __('Editar Partner', 'os_partner_type'),
                    'view_item' => __('Ver Partner', 'os_partner_type'),
                    'parent_item_colon' => __(' ', 'os_partner_type'),
                    'search_items' => __('Buscar Partners', 'os_partner_type'),
                    'not_found' => __('No se han encontrado partners', 'os_partner_type'),
                    'not_found_in_trash' => __('No se han encontrado partners en la papelera', 'os_partner_type'),
                    'menu_name' => __('Partners', 'os_partner_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different partners", "os_partner_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Partner'),
                'menu_icon' =>  'dashicons-admin-site',
                'supports' => array("title"),
                'taxonomies' => array('ambito_geografico')
            ));
        }



    }

    $osPartners = new PartnerCustomType();


endif;

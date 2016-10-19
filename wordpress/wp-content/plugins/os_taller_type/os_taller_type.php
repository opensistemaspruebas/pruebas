<?php

/*
    Plugin Name: OS Taller Type
    Plugin URI: http://www.opensistemas.com/
    Description: Crea el tipo de contenido 'taller'.
    Version: 1.0
    Author: Roberto Moreno
    Author Email: rmoreno@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: os_taller_type
    License: GPLv2 
*/

if (!class_exists('TallerCustomType')) :
  
   class TallerCustomType {   
        
        var $post_type = "taller";
        
        function __construct() {
            add_action('init', array(&$this, 'create_post_type'));
            add_action('add_meta_boxes', array(&$this, 'meta_boxes_add'));
            add_action('save_post', array(&$this, "meta_boxes_save"));
            add_action('plugins_loaded', array(&$this, 'load_text_domain'), 10);
        }


        // Selecciona el dominio para la traducción
        function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_taller_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Talleres', 'os_taller_type'),
                    'singular_name' => __('Taller', 'os_taller_type'),
                    'add_new' => __('Añadir nuevo', 'os_taller_type'),
                    'add_new_item' => __('Añadir nuevo Taller', 'os_taller_type'),
                    'new_item' => __('Nuevo Taller', 'os_taller_type'),
                    'edit_item' => __('Editar Taller', 'os_taller_type'),
                    'view_item' => __('Ver Taller', 'os_taller_type'),
                    'update_item' => __('Actualizar taller', 'os_taller_type'),
                    'parent_item_colon' => __('Superior:', 'os_taller_type'),
                    'search_items' => __('Buscar Talleres', 'os_taller_type'),
                    'not_found' => __('No se han encontrado talleres.', 'os_taller_type'),
                    'not_found_in_trash' => __('No se han encontrado talleres en la papelera.', 'os_taller_type'),
                    'menu_name' => __('Talleres', 'os_taller_type')
                ),
                'capability_type' => 'post',
                'description' => __("Este tipo de contenido genera diferentes talleres", "os_taller_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'taller'),
                'menu_icon' =>  'dashicons-hammer',
                'supports' => array('title'),
                'taxonomies' => array('ambito_geografico')
                
            ));
        }


        // Añade los meta-boxes al tipo de post tool
        function meta_boxes_add() {

            add_meta_box("talleres_data" ,__("Información de taller", "os_taller_type"),array(&$this, "taller_data_meta_box_callback"),$this->post_type);            
        }


        function taller_data_meta_box_callback($post) {

            wp_nonce_field( basename(__FILE__), 'taller-nonce');  
            
            $descp = get_post_meta($post->ID, 'descp', true);
            $link_taller = get_post_meta( $post->ID, 'link_taller', true);
            $nombre_link = get_post_meta( $post->ID, 'nombre_link', true);
            $externo = get_post_meta($post->ID, 'externo', true);
            ?>          
            <p>
                <label for="descp"><?php _e('Descripción', 'os_taller_type')?></label>
               <textarea rows="4" class="widefat" name="descp" id="descp" ><?php if ( isset($descp) ) echo $descp; ?></textarea>
            </p>
            <p>
                <label for="nombre_link"><?php _e('Nombre del enlace', 'os_taller_type')?></label>
                <input class="widefat" type="text" name="nombre_link" id="nombre_link" value="<?php if ( isset($nombre_link) ) echo $nombre_link; ?>" />
            </p>
            <p>
                <label for="link_taller"><?php _e('Enlace al taller', 'os_taller_type')?></label>
                <input class="widefat" type="url" name="link_taller" id="link_taller" value="<?php if ( isset($link_taller) ) echo $link_taller; ?>" />
            </p>
            <p>
                <input class="widefat" id="externo" name="externo" type="checkbox" <?php checked($externo, 'on'); ?> />
                <label for="externo"><?php _e('Abrir enlace en una nueva ventana', 'os_taller_type'); ?></label>
            </p>
            <?php
        }



        function meta_boxes_save($post_id) {            
            if (isset($_POST['descp'])) {
                update_post_meta($post_id, 'descp', strip_tags($_POST['descp']));
            }
            if (isset($_POST['nombre_link'])) {
                update_post_meta( $post_id, 'nombre_link', strip_tags($_POST['nombre_link']));
            }
            if (isset($_POST['link_taller'])) {
                update_post_meta( $post_id, 'link_taller', strip_tags($_POST['link_taller']));
            }
            if (isset($_POST['externo'])) {
                update_post_meta($post_id, 'externo', strip_tags($_POST['externo']));
            } else {
                 update_post_meta($post_id, 'externo', "off");
            }
        }

    }

    $osTaller = new TallerCustomType();


endif;
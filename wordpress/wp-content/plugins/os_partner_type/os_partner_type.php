<?php
/*
Plugin Name: OS Partner type
Plugin URI: http://www.opensistemas.com
Description: Crea el tipo de contenido 'partner'
Version: 1.0
Author: Roberto Ojosnegros 
Author URI: http://www.opensistemas.com/
Author email: ropavon@opensistemas.com
Text Domain: os_partner_type
License: GPL2
*/

/* 
Copyright (C) 2016 ropavon

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

if (!class_exists('PartnerCustomType')) :
  
   class PartnerCustomType 
   {   
        var $post_type = "partner";

        
        function __construct() {
            add_action('init', array(&$this, 'create_post_type'));
            add_action('add_meta_boxes', array(&$this, 'meta_boxes_add'));
            add_action('save_post', array(&$this, "meta_boxes_save"));
            add_action('plugins_loaded', array(&$this, 'load_text_domain'), 10);
        }

        // Selecciona Dominio para la traducción
        function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_partner_type', false, $plugin_dir . "/languages");
        }

        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Partners', 'os_partner_type'),
                    'singular_name' => __('Partner', 'os_partner_type'),
                    'add_new' => __('Añadir nuevo', 'os_partner_type'),
                    'add_new_item' => __('Añadir nuevo Partner', 'os_partner_type'),
                    'new_item' => __('Nuevo Partner', 'os_partner_type'),
                    'edit_item' => __('Editar Partner', 'os_partner_type'),
                    'view_item' => __('Ver Partner', 'os_partner_type'),
                    'parent_item_colon' => __(' ', 'os_partner_type'),
                    'search_items' => __('Buscar Partners', 'os_partner_type'),
                    'not_found' => __('No se han encontrado partners', 'os_partner_type'),
                    'not_found_in_trash' => __('No hay partners en la papelera', 'os_partner_type'),
                    'menu_name' => __('Partners', 'os_partner_type')
                ),
                'capability_type' => 'post',
                'description' => __("En este tipo de post se encuentran los partners", "os_partner_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'partner'),
                //'menu_position' => 4,
                'menu_icon' =>  'dashicons-businessman',
                'supports' => array("title", "editor","thumbnail"),
                )
            );
        }

        /**
         * Añade los meta-boxes al tipo de post Awards
         */
        function meta_boxes_add() {
            add_meta_box("enlace-externo", __("Enlace a partner", "os_perfil_type"), array(&$this, "enlace_meta_box_callback"), $this->post_type,"advanced","default");
        }

        function enlace_meta_box_callback($post) {
            wp_nonce_field( basename( __FILE__ ), 'enlace-partner-nonce' );
            $enlace = get_post_meta( $post->ID, 'enlace-partner' , true);
            ?>
         
            <p>
                <label for="enlace-partner" class="autor-row-title"><?php _e( 'URL externa del partner', 'os_partner_type' )?></label>
                <input type="text" class="widefat" name="enlace-partner" id="enlace-partner" value="<?php if ( $enlace !== '') { echo $enlace; } else { echo 'http://'; } ?>" />
            </p>
         
            <?php
        }

        function meta_boxes_save($post_id) {
            if( $this->user_can_save( $post_id, 'autor-nonce' ) ) {
                // Checks for input and saves if needed
                if( isset( $_POST[ 'enlace-partner' ] ) ) {
                    update_post_meta( $post_id, 'enlace-partner', $_POST[ 'enlace-partner' ] );
                }
            }
        }

        //////////////// FUNCIONES PRIVADAS ////////////////////

        /*
        * Comprueba si el usuario puede salvar los cambios
        */
        private function user_can_save( $post_id, $nonce ) {
 
           // Checks save status
            $is_autosave = wp_is_post_autosave( $post_id );
            $is_revision = wp_is_post_revision( $post_id );
            $is_valid_nonce = ( isset( $_POST[ $nonce ] ) && wp_verify_nonce( $_POST[ $nonce ], basename( __FILE__ ) ) ) ? 'true' : 'false';
         
            // Exits script depending on save status
            if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
                return false;
            }
           return true;
        }



    }

    $osPartner = new PartnerCustomType();

endif;

?>

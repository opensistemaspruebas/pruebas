<?php
/*
Plugin Name: OS Organizaciones Partners Parent Type
Plugin URI: http://www.opensistemas.com
Description: Crea el tipo de contenido ''
Version: 1.0
Author: Roberto Moreno 
Author URI: http://www.opensistemas.com/
Author email: rmoreno@opensistemas.com
Text Domain: os_organizaciones_partners_parent_type
License: GPL2
*/

if (!class_exists('OrganizacionesPartnersCustomType')) :
  
   class OrganizacionesPartnersCustomType {   
       
        var $post_type = "organizacionesPartners";
        
        function __construct() {
            add_action('init', array(&$this, 'create_post_type'));
            add_action('add_meta_boxes', array(&$this, 'meta_boxes_add'));
            add_action('save_post', array(&$this, "meta_boxes_save"));
            //add_action('admin_enqueue_scripts', 'register_admin_scripts');

        }

        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                ),
                'capability_type' => 'post',
                'public' => false,
                'show_ui' => false,
                'hierarchical' => false,
                'has_archive' => true,
                'menu_icon' =>  'dashicons-exerpt-view',
                'supports' => array("title")
            ));

                wp_enqueue_media();
                wp_register_script('os_organizaciones_partners_parent_type-js', plugins_url('js/os_organizaciones_partners_parent_type.js' , __FILE__), array('jquery'));           
                $translation_array = array(
                'choose_organization_logo' => __('Seleccionar logo', 'os_organizaciones_partners_parent_type')
            );
                wp_localize_script( 'os_organizaciones_partners_parent_type-js', 'object_name', $translation_array );
                wp_enqueue_script('os_organizaciones_partners_parent_type-js');
        }

     function register_admin_scripts() {
        
        global $typenow, $post;
        
        if ($typenow == $post->post_type) {
                wp_enqueue_media();
                wp_register_script('os_organizaciones_partners_parent_type-js', plugins_url('js/os_organizaciones_partners_parent_type.js' , __FILE__), array('jquery'));           
                $translation_array = array(
                'choose_organization_logo' => __('Seleccionar logo', 'os_organizaciones_partners_parent_type')
            );
                wp_localize_script( 'os_organizaciones_partners_parent_type-js', 'object_name', $translation_array );
                wp_enqueue_script('os_organizaciones_partners_parent_type-js');
            }
        }



        // Añade los meta-boxes al tipo de post tool
        function meta_boxes_add() {

            add_meta_box("organizacionesPartners-data" ,__("Datos", "os_organizaciones_partners_parent_type"),array(&$this, "organizacionesPartners_data_meta_box_callback"),$this->post_type);
        }




        function organizacionesPartners_data_meta_box_callback($post) {

            wp_nonce_field( basename(__FILE__), 'organizaciones_partner-nonce');         
            
            $nombre = get_post_meta($post->ID, 'nombre');
            $descripcion = get_post_meta($post->ID, 'descripcion');
            $link = get_post_meta( $post->ID, 'link');
            $logoMP = get_post_meta($post->ID, 'logoMP', true);
            $logoMP_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($logoMP));
            $externo5 = get_post_meta($post->ID, 'externo5', true);

            ?>      

            <p>
                <label for="nombre"><?php _e('Nombre', 'os_organizaciones_partners_parent_type')?></label>
                <input type="text" class="widefat" name="nombre" id="nombre" value="<?php if ( isset($nombre) ) echo $nombre[0]; ?>" />
            </p>
            <p>
                <label for="descripcion"><?php _e('Descripción', 'os_organizaciones_partners_parent_type')?></label>
                <textarea name="descripcion" rows="4" class="widefat" id="descripcion"><?php if ( isset($descripcion) ) echo $descripcion[0]; ?></textarea>
            </p>
            <p>
                <label for="link"><?php _e('Link', 'os_organizaciones_partners_parent_type')?></label>
                <input type="url" class="widefat" name="link" id="link" value="<?php if ( isset($link) ) echo $link[0]; ?>" />
            </p>
              <p>
                <input class="widefat" id="externo5" name="externo5" type="checkbox" <?php checked($externo5, 'on'); ?> />
                <label for="externo5"><?php _e('Abrir enlace en una nueva ventana', 'os_organizaciones_partners_parent_type'); ?></label>
              </p>
             <p>
                <label for="logoMP"><?php _e('Logo', 'os_organizaciones_partners_parent_type'); ?></label>
                <input class="widefat" id="logoMP" name="logoMP" type="text" value="<?php if (!empty($logoMP)) echo $logoMP; ?>" readonly="readonly"/>
                <img id="show_logoMP" draggable="false" alt="" name="show_logoMP" src="<?php if (!empty($logoMP_thumbnail)) echo esc_attr($logoMP_thumbnail); ?>" style="<?php if (empty($logoMP_thumbnail)) echo "display: none;"; ?>">
            </p>
            <p>
                <input id="upload_logoMP" name="upload_logoMP" type="button" value="<?php _e('Explorar/Subir', 'os_organizaciones_partners_parent_type'); ?>" />
            </p>
            <?php 
        }


        function meta_boxes_save($post_id) {            
            if (isset($_POST['nombre'])) {
                update_post_meta($post_id, 'nombre', strip_tags($_POST['nombre']));
            }
            if (isset($_POST['descripcion'])) {
                update_post_meta($post_id, 'descripcion', strip_tags($_POST['descripcion']));
            }
            if (isset($_POST['link'])) {
                update_post_meta( $post_id, 'link', strip_tags($_POST['link']));
            }
            if (isset($_POST['logoMP'])) {
                update_post_meta($post_id, 'logoMP', strip_tags($_POST['logoMP']));
            }
            if (isset($_POST['externo5'])) {
                update_post_meta($post_id, 'externo5', strip_tags($_POST['externo5']));
            } else {
                 update_post_meta($post_id, 'externo5', "off");
            }
        }


    }

    $osOrganizacionesPartners = new OrganizacionesPartnersCustomType();


endif;
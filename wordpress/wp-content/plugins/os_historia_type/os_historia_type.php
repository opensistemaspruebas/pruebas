<?php

/*
    Plugin Name: OS Historia Type
    Plugin URI: http://www.opensistemas.com/
    Description: Creates the content type 'Historia'
    Version: 1.0
    Historia: Roberto Moreno
    Historia Email: rmoreno@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: os_historia_type
    License: GPLv2 
*/

if (!class_exists('HistoriaCustomType')) :
  
   class HistoriaCustomType {   
        
        var $post_type = "historia";
        
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
            load_plugin_textdomain('os_historia_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
            register_post_type($this->post_type, array(
                 'labels' => array(
                    'name' => __('Historia', 'os_equipo_Historia_type'),
                    'singular_name' => __('Historia', 'os_equipo_Historia_type'),
                    'add_new' => __('Añadir nueva Historia', 'os_equipo_Historia_type'),
                    'add_new_item' => __('Añadir nueva Historia', 'os_equipo_Historia_type'),
                    'new_item' => __('Nuevo Historia', 'os_equipo_Historia_type'),
                    'edit_item' => __('Editar Historia', 'os_equipo_Historia_type'),
                    'view_item' => __('Ver Historia', 'os_equipo_Historia_type'),
                    'parent_item_colon' => __(' ', 'os_equipo_Historia_type'),
                    'search_items' => __('Buscar Historia', 'os_equipo_Historia_type'),
                    'not_found' => __('Historia no encontrado', 'os_equipo_Historia_type'),
                    'not_found_in_trash' => __('Historia no encontrado en la papelera', 'os_equipo_Historia_type'),
                    'menu_name' => __('Historia', 'os_equipo_Historia_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different Historias", "os_historia_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Historia'),
                'menu_icon' =>  'dashicons-exerpt-view',
                'supports' => array("title")
            ));
        }


        // Añade los meta-boxes al tipo de post tool
        function meta_boxes_add() {

            add_meta_box("data" ,__("Datos de la historia", "os_historia_type"),array(&$this, "Historia_data_meta_box_callback"),$this->post_type);
            add_meta_box("image" ,__("Image Historia", "os_historia_type"),array(&$this, "image_meta_box_callback"),$this->post_type);            
        }


        function Historia_data_meta_box_callback($post) {

            wp_nonce_field( basename(__FILE__), 'Historia-nonce');         
            
            $name = get_post_meta($post->ID, 'name');
            $birthdate = get_post_meta($post->ID, 'birthdate');
            $placeBirth = get_post_meta( $post->ID, 'placeBirth');
            $bio = get_post_meta( $post->ID, 'bio');
            $relatedWork = get_post_meta( $post->ID, 'relatedWork');
            ?>          
            <p>
                <label for="name"><?php _e('Name', 'os_historia_type')?></label>
                <input type="text" name="name" id="name" value="<?php if ( isset($name) ) echo $name[0]; ?>" />
            </p>
            <p>
                <label for="birthdate"><?php _e('Birthdate', 'os_historia_type')?></label>
                <input type="text" name="birthdate" id="birthdate" value="<?php if ( isset($birthdate) ) echo $birthdate[0]; ?>" />
            </p>
            <p>
                <label for="placeBirth"><?php _e('Place birth', 'os_historia_type')?></label>
                <input type="text" name="placeBirth" id="placeBirth" value="<?php if ( isset($placeBirth) ) echo $placeBirth[0]; ?>" />
            </p>
            <p>
                <label for="bio"><?php _e('Bio', 'os_historia_type')?></label>
                <input type="text" name="bio" id="bio" value="<?php if ( isset($bio) ) echo $bio[0]; ?>" />
            </p>
            <p>
                <label for="relatedWork"><?php _e('Related Work', 'os_historia_type')?></label>
                <input type="text" name="relatedWork" id="relatedWork" value="<?php if ( isset($relatedWork) ) echo $relatedWork[0]; ?>" />
            </p>
            <?php
        }


        
        function image_meta_box_callback($post) {           
            
            // Get WordPress' media upload URL
            $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

            // See if there's a media id already saved as post meta
            $your_img_id = get_post_meta( $post->ID, 'image', true );

            // Get the image src
            $your_img_src = wp_get_attachment_image_src( $your_img_id, 'full' );

            // For convenience, see if the array is valid
            $you_have_img = is_array( $your_img_src );
            ?>

            <!-- Your image container, which can be manipulated with js -->
            <div class="custom-img-container">
                <?php if ( $you_have_img ) : ?>
                    <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:50%;" />
                <?php endif; ?>
            </div>

            <!-- Your add & remove image links -->
            <p class="hide-if-no-js">
                <a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
                   href="<?php echo $upload_link ?>">
                    <?php _e('Set custom image') ?>
                </a>
                <a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
                  href="#">
                    <?php _e('Remove this image') ?>
                </a>
            </p>

            <!-- A hidden input to set and post the chosen image id -->
            <input class="image" name="image" type="hidden" value="<?php echo esc_attr( $your_img_id ); ?>"
            <?php
       
        }



        function meta_boxes_save($post_id) {            
            if (isset($_POST['name'])) {
                update_post_meta($post_id, 'name', strip_tags($_POST['name']));
            }
            if (isset($_POST['birthdate'])) {
                update_post_meta($post_id, 'birthdate', strip_tags($_POST['birthdate']));
            }
            if (isset($_POST['placeBirth'])) {
                update_post_meta( $post_id, 'placeBirth', strip_tags($_POST['placeBirth']));
            }
            if (isset($_POST['bio'])) {
                update_post_meta( $post_id, 'bio', strip_tags($_POST['bio']));
            }
            if (isset($_POST['relatedWork'])) {
                update_post_meta( $post_id, 'relatedWork', strip_tags($_POST['relatedWork']));
            }
        }


        function register_admin_styles(){
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_style('os-historia-type-css', plugin_dir_url( __FILE__ ) . 'css/os_historia_type.css');               
            }
        }


        function register_admin_scripts() {
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_media();
                wp_register_script('os-historia-type-js', plugins_url('js/os_historia_type.js' , __FILE__), array('jquery'));
                wp_enqueue_script('os-historia-type-js');
            }
        }

    }

    $osHistoria = new HistoriaCustomType();


endif;
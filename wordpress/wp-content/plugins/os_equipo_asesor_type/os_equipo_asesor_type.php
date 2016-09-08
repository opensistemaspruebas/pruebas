<?php

/*
    Plugin Name: OS Equipo Asesor Type
    Plugin URI: http://www.opensistemas.com/
    Description: Creates the content type 'Equipo Asesor'
    Version: 1.0
    Author: Roberto Moreno
    Author Email: rmoreno@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: os_equipo_asesor_type
    License: GPLv2 
*/

if (!class_exists('AsesorCustomType')) :
  
   class AsesorCustomType {   
        
        var $post_type = "asesor";
        
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
            load_plugin_textdomain('os_equipo_asesor_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
            register_post_type($this->post_type, array(
               'labels' => array(
                    'name' => __('Asesor', 'os_equipo_Coordinador_type'),
                    'singular_name' => __('Asesor', 'os_equipo_Coordinador_type'),
                    'add_new' => __('Añadir nuevo asesor', 'os_equipo_Coordinador_type'),
                    'add_new_item' => __('Añadir nuevo asesor', 'os_equipo_Coordinador_type'),
                    'new_item' => __('Nuevo asesor', 'os_equipo_Coordinador_type'),
                    'edit_item' => __('Editar asesor', 'os_equipo_Coordinador_type'),
                    'view_item' => __('Ver asesor', 'os_equipo_Coordinador_type'),
                    'parent_item_colon' => __(' ', 'os_equipo_Coordinador_type'),
                    'search_items' => __('Buscar asesor', 'os_equipo_Coordinador_type'),
                    'not_found' => __('Asesor no encontrado', 'os_equipo_Coordinador_type'),
                    'not_found_in_trash' => __('Asesor no encontrado en la papelera', 'os_equipo_Coordinador_type'),
                    'menu_name' => __('Asesor', 'os_equipo_Coordinador_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different authors", "os_equipo_asesor_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Author'),
                'menu_icon' =>  'dashicons-exerpt-view',
                'supports' => array("title")
            ));
        }


        // Añade los meta-boxes al tipo de post tool
        function meta_boxes_add() {
			add_meta_box("intro" ,__("Introducción del asesor", "os_equipo_asesor_type"),array(&$this, "asesor_intro_meta_box_callback"),$this->post_type);
            add_meta_box("datos" ,__("Datos del asesor", "os_equipo_asesor_type"),array(&$this, "asesor_datos_meta_box_callback"),$this->post_type);
            add_meta_box("trabajo" ,__("Sobre el trabajo del asesor", "os_equipo_asesor_type"),array(&$this, "trabajo_meta_box_callback"),$this->post_type);            
        }

		function asesor_intro_meta_box_callback($post) {
			// Get WordPress' media upload URL
            $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

            // See if there's a media id already saved as post meta
            $your_img_id = get_post_meta( $post->ID, 'image', true );

            // Get the image src
            $your_img_src = wp_get_attachment_image_src( $your_img_id, 'full' );

            // For convenience, see if the array is valid
            $you_have_img = is_array( $your_img_src );
            
            $cita = get_post_meta($post->ID, 'cita');
             ?> 
            
            <div id="autor_cabeceraImagen"> 
                <!-- Your image container, which can be manipulated with js -->
                <div class="custom-img-container">
                    <?php if ( $you_have_img ) : ?>
                        <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:50%;" />
                    <?php endif; ?>
                </div>
    
                <!-- Your add & remove image links -->
                <span>Imagen de cabecera:</span>
                <span class="hide-if-no-js">
                    <a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
                       href="<?php echo $upload_link ?>">
                        <?php _e('Seleccionar imagen') ?>
                    </a>
                    <a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
                      href="#">
                        <?php _e('Quitar imagen') ?>
                    </a>
                </span>
    
                <!-- A hidden input to set and post the chosen image id -->
                <input class="image" name="image" type="hidden" value="<?php echo esc_attr( $your_img_id ); ?>" />
            </div>
            <div id="autor_cabeceraCita"> 
                <label for="cita"><?php _e('Cita', 'os_equipo_asesor_type')?></label>
                <input type="text" name="cita" id="cita" value="<?php if ( isset($cita) ) echo $cita[0]; ?>" />
            </div>
            <?php
       
        }
		
		
        function asesor_datos_meta_box_callback($post) {

            wp_nonce_field( basename(__FILE__), 'author-nonce');         
            
            $nombre = get_post_meta($post->ID, 'nombre');
            $cargo = get_post_meta($post->ID, 'cargo');
            $linkedin = get_post_meta( $post->ID, 'linkedin');
            $email = get_post_meta( $post->ID, 'email');
            $telefono = get_post_meta( $post->ID, 'telefono');
            $logoEmpresa = get_post_meta( $post->ID, 'logoEmpresa');
           
			
			// Subir foto del asesor
            $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );
            $your_img_id = get_post_meta( $post->ID, 'image', true );
            $your_img_src = wp_get_attachment_image_src( $your_img_id, 'full' );
            $you_have_img = is_array( $your_img_src );
			
            ?>     
                 
            <p>
                <label for="nombre"><?php _e('Nombre', 'os_equipo_asesor_type')?></label>
                <input type="text" name="nombre" id="nombre" value="<?php if ( isset($nombre) ) echo $nombre[0]; ?>" />
            </p>
            <p>
                <label for="cargo"><?php _e('Cargo', 'os_equipo_asesor_type')?></label>
                <input type="text" name="cargo" id="cargo" value="<?php if ( isset($cargo) ) echo $cargo[0]; ?>" />
            </p>
            <p>
                <label for="linkedin"><?php _e('Linkedin', 'os_equipo_asesor_type')?></label>
                <input type="text" name="linkedin" id="linkedin" value="<?php if ( isset($linkedin) ) echo $linkedin[0]; ?>" />
            </p>
            <p>
                <label for="email"><?php _e('Email', 'os_equipo_asesor_type')?></label>
                <input type="text" name="email" id="email" value="<?php if ( isset($email) ) echo $email[0]; ?>" />
            </p>
            <p>
                <label for="telefono"><?php _e('Telefono', 'os_equipo_asesor_type')?></label>
                <input type="text" name="telefono" id="telefono" value="<?php if ( isset($telefono) ) echo $telefono[0]; ?>" />
            </p>
            
            <div id="autor_foto"> 
                <!-- Your image container, which can be manipulated with js -->
                <div class="custom-img-container">
                    <?php if ( $you_have_img ) : ?>
                        <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:50%;" />
                    <?php endif; ?>
                </div>
    
                <!-- Your add & remove image links -->
                <span>Foto del asesor:</span>
                <span class="hide-if-no-js">
                    <a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
                       href="<?php echo $upload_link ?>">
                        <?php _e('Seleccionar imagen') ?>
                    </a>
                    <a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
                      href="#">
                        <?php _e('Quitar imagen') ?>
                    </a>
                </span>
    
                <!-- A hidden input to set and post the chosen image id -->
                <input class="image" name="image" type="hidden" value="<?php echo esc_attr( $your_img_id ); ?>" />
            </div>
            <?php
        }
		
        
        function trabajo_meta_box_callback($post) {           
             wp_nonce_field( basename(__FILE__), 'author-nonce');         
            
             $numeroPublicaciones = get_post_meta( $post->ID, 'numeroPublicaciones');
             $areasExpertise = get_post_meta( $post->ID, 'areasExpertise');
             $biografia = get_post_meta( $post->ID, 'biografia');
          
		  ?>     
                 
            <p>
                <label for="numeroPublicaciones"><?php _e('Número de publicaciones', 'os_equipo_asesor_type')?></label>
                <input type="text" name="numeroPublicaciones" id="numeroPublicaciones" value="<?php if ( isset($numeroPublicaciones) ) echo $numeroPublicaciones[0]; ?>" />
            </p>
            <p>
                <label for="areasExpertise"><?php _e('Áreas de expertise', 'os_equipo_asesor_type')?></label>
                <input type="text" name="areasExpertise" id="areasExpertise" value="<?php if ( isset($areasExpertisergo) ) echo $areasExpertise[0]; ?>" />
                <input type="text" name="areasExpertise" id="areasExpertise" value="<?php if ( isset($areasExpertisergo) ) echo $areasExpertise[0]; ?>" />
                <input type="text" name="areasExpertise" id="areasExpertise" value="<?php if ( isset($areasExpertisergo) ) echo $areasExpertise[0]; ?>" />
            </p>
            <p>
                <label for="biografia"><?php _e('Biografia', 'os_equipo_asesor_type')?></label>
                <textarea type="text" name="biografia" id="biografia" value="<?php if ( isset($biografia) ) echo $biografia[0]; ?>"></textarea>
            </p>
            
      	 <?php
        }



        function meta_boxes_save($post_id) {      
			if (isset($_POST['cita'])) {
                update_post_meta($post_id, 'cita', strip_tags($_POST['cita']));
            }      
            if (isset($_POST['nombre'])) {
                update_post_meta($post_id, 'nombre', strip_tags($_POST['nombre']));
            }
            if (isset($_POST['cargo'])) {
                update_post_meta($post_id, 'cargo', strip_tags($_POST['cargo']));
            }
            if (isset($_POST['linkedin'])) {
                update_post_meta( $post_id, 'linkedin', strip_tags($_POST['linkedin']));
            }
            if (isset($_POST['email'])) {
                update_post_meta( $post_id, 'email', strip_tags($_POST['email']));
            }
            if (isset($_POST['telefono'])) {
                update_post_meta( $post_id, 'telefono', strip_tags($_POST['telefono']));
            }
			if (isset($_POST['numeroPublicaciones'])) {
                update_post_meta( $post_id, 'numeroPublicaciones', strip_tags($_POST['numeroPublicaciones']));
            }
			if (isset($_POST['areasExpertise'])) {
                update_post_meta( $post_id, 'areasExpertise', strip_tags($_POST['areasExpertise']));
            }
			if (isset($_POST['biografia'])) {
                update_post_meta( $post_id, 'biografia', strip_tags($_POST['biografia']));
            }
        }


        function register_admin_styles(){
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_style('asesor-type-css', plugin_dir_url( __FILE__ ) . 'css/os_equipo_asesor_type.css');               
            }
        }


        function register_admin_scripts() {
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_media();
                wp_register_script('os-asesor-type-js', plugins_url('js/os_equipo_asesor_type.js' , __FILE__), array('jquery'));
                wp_enqueue_script('os-asesor-type-js');
            }
        }

    }

    $osAsesor = new AsesorCustomType();


endif;
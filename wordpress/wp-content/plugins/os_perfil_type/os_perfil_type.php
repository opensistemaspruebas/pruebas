<?php
/*
Plugin Name: OS Perfil type
Plugin URI: http://www.opensistemas.com
Description: Crea el tipo de contenido 'perfil'
Version: 1.0
Author: Roberto Ojosnegros 
Author URI: http://www.opensistemas.com/
Author email: ropavon@opensistemas.com
Text Domain: os_perfiles_type
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

if (!class_exists('PerfilCustomType')) :
  
   class PerfilCustomType 
   {   
        var $post_type = "perfil";

        
        function __construct() {
            add_action('init', array(&$this, 'create_post_type'));
            add_action('add_meta_boxes', array(&$this, 'meta_boxes_add'));
            add_action('save_post', array(&$this, "meta_boxes_save"));
            add_action('admin_print_styles', array(&$this,'register_admin_styles'));
            add_action('admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));
            //add_filter('manage_edit-perfil_columns', array(&$this,'edit_testimonies_columns'));
            //add_action('manage_perfil_posts_custom_column', array(&$this,'manage_testimonies_columns'), 10, 2);
            //add_filter('manage_edit-perfil_sortable_columns', array(&$this, 'testimonies_sortable_columns'));
            //add_action('load-edit.php', array(&$this,'edit_testimonies_load'));
            add_action('plugins_loaded', array(&$this, 'load_text_domain'), 10);
        }

        // Selecciona Dominio para la traducción
        function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_perfil_type', false, $plugin_dir . "/languages");
        }

        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Perfiles', 'os_perfil_type'),
                    'singular_name' => __('Perfil', 'os_perfil_type'),
                    'add_new' => __('Añadir nuevo', 'os_perfil_type'),
                    'add_new_item' => __('Añadir nuevo Perfil', 'os_perfil_type'),
                    'new_item' => __('Nuevo Perfil', 'os_perfil_type'),
                    'edit_item' => __('Editar Perfil', 'os_perfil_type'),
                    'view_item' => __('Ver Perfil', 'os_perfil_type'),
                    'parent_item_colon' => __(' ', 'os_perfil_type'),
                    'search_items' => __('Buscar Perfiles', 'os_perfil_type'),
                    'not_found' => __('No se han encontrado perfiles', 'os_perfil_type'),
                    'not_found_in_trash' => __('No hay perfiles en la papelera', 'os_perfil_type'),
                    'menu_name' => __('Perfiles', 'os_perfil_type')
                ),
                'capability_type' => 'post',
                'description' => __("En este tipo de post se encuentran los perfiles", "os_perfil_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Perfil'),
                //'menu_position' => 4,
                'menu_icon' =>  'dashicons-id',
                'supports' => array("title", "revisions")
                )
            );
        }

        /**
         * Añade los meta-boxes al tipo de post Awards
         */
        function meta_boxes_add() {
            add_meta_box("t-author", __("Información básica", "os_perfil_type"), array(&$this, "author_meta_box_callback"), $this->post_type,"advanced","default");
            add_meta_box("tipo-perfil", __("Tipo de perfil", "os_perfil_type"), array(&$this, "tipo_meta_box_callback"), $this->post_type,"side","high");
            add_meta_box("detalles",__("Detalles de Consejero/Coordinador", "os_perfil_type"),array(&$this, "detalles_meta_box_callback"),$this->post_type,"advanced","default");
            add_meta_box("detalles-asesor",__("Detalles de Asesor", "os_perfil_type"),array(&$this, "detalles_asesor_meta_box_callback"),$this->post_type,"advanced","default");

            //add_meta_box("featured-testimony", __("Featured testimony", "os_perfil_type"), array(&$this, "featured_meta_box_callback"), $this->post_type,"side");
            //add_meta_box("video-testimony",__("Link to the video", "os_perfil_type"),array(&$this,"vt_meta_box_callback"),$this->post_type,"side","low");
        }

        function author_meta_box_callback($post) {
        	wp_nonce_field( basename( __FILE__ ), 'autor-nonce' );
            $nombre = get_post_meta( $post->ID, 'meta-autor-nombre' );
            $estudios = get_post_meta( $post->ID, 'meta-autor-estudios' );
            ?>
         
            <p>
                <label for="meta-autor-nombre" class="autor-row-title"><?php _e( 'Nombre', 'os_perfil_type' )?></label>
                <input type="text" name="meta-autor-nombre" class="required" id="meta-autor-nombre" value="<?php if ( $nombre !== '') echo $nombre[0]; ?>" />
            </p>
            <p>
                <label for="meta-autor-estudios" class="autor-row-title"><?php _e( 'Estudios', 'os_perfil_type' )?></label>
                <input type="text" name="meta-autor-estudios" class="required" id="meta-autor-estudios" value="<?php if ( $estudios !== '' ) echo $estudios[0]; ?>" />
            </p>
         
            <?php
        }

        function tipo_meta_box_callback($post) {
            wp_nonce_field( basename( __FILE__ ), 'tipo-nonce' );
            $cargo = get_post_meta( $post->ID, 'tipo-perfil' )[0];

            $posiblesCargos = array(
                'autor' =>  __("Autor", "os_perfil_type"),
                'consejero' =>  __("Consejero", "os_perfil_type"),
                'coordinador' =>  __("Coordinador de grupo", "os_perfil_type"),
                'asesor' =>  __("Asesor de grupo", "os_perfil_type"));

            foreach($posiblesCargos as $key => $label) {
                foreach ($cargo as $k => $val) {
                    if($val == $key) {
                        $checked = 'checked=checked';
                        break;
                    }
                    $checked = '';
                }
                
                $inputs .= '<input type="checkbox" name="tipo-perfil[]" value="' . esc_attr($key) . '" id="tipo-perfil[' . esc_attr($key) . ']" ' . $checked . ' />'.
                '<label for="tipo-perfil[' . esc_attr($key) . ']"> ' . esc_html($label) . ' ' .
                '</label><br>';
            }

            echo $inputs;

        }

        function detalles_meta_box_callback($post) {
            wp_nonce_field( basename( __FILE__ ), 'detalles-nonce' );
            $fotoPerfil = get_post_meta( $post->ID, 'foto-perfil' );
            $fotoPerfil_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($fotoPerfil));

            $cargo = get_post_meta( $post->ID, 'titulo-cargo' );

            $lugarTrabajo = get_post_meta( $post->ID, 'lugar-trabajo' );

            $logoTrabajo = get_post_meta( $post->ID, 'logo-trabajo' );
            $logoTrabajo_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($logoTrabajo));

            $enlaceLinkedin = get_post_meta( $post->ID, 'enlace-linkedin' );

            $email = get_post_meta( $post->ID, 'email' );

            $web = get_post_meta( $post->ID, 'web' );

            $fotoGrande = get_post_meta( $post->ID, 'foto-grande' );
            $fotoGrande_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($fotoGrande));

            $fraseFotoGrande = get_post_meta( $post->ID, 'frase-foto-grande' );

            $areaExpertise1 = get_post_meta( $post->ID, 'area-expertise-1' );
            $areaExpertise2 = get_post_meta( $post->ID, 'area-expertise-2' );
            $areaExpertise3 = get_post_meta( $post->ID, 'area-expertise-3' );

            ?>
         
            <div class="imagen">
                <label for="foto-perfil"><?php _e('Foto de perfil', 'os_perfil_type'); ?></label>
                <img id="show_foto" draggable="false" alt="" name="show_foto" src="<?php if (!empty($fotoPerfil_thumbnail)) echo esc_attr($fotoPerfil_thumbnail); ?>" style="<?php if (empty($fotoPerfil_thumbnail)) echo "display: none;"; ?>">
                <div class="centered">
                    <input class="widefat" id="foto-perfil" name="foto-perfil" type="text" value="<?php if (!empty($fotoPerfil)) echo $fotoPerfil; ?>" readonly="readonly"/>
                    <input id="upload_foto" name="upload_foto" type="button" value="<?php _e('Explorar/Subir', 'os_perfil_type'); ?>" />
                </div>
            </div>

            <p>
                <label for="titulo-cargo" class="autor-row-title"><?php _e('Título/Cargo', 'os_perfil_type' )?></label>
                <input type="text" name="titulo-cargo" id="titulo-cargo" value="<?php if ( $cargo !== '' ) echo $cargo[0]; ?>" />
            </p>

            <p>
                <label for="lugar-trabajo" class="autor-row-title"><?php _e( 'Lugar de trabajo', 'os_perfil_type' )?></label>
                <input type="text" name="lugar-trabajo" id="lugar-trabajo" value="<?php if ( $lugarTrabajo !== '' ) echo $lugarTrabajo[0]; ?>" />
            </p>

            <div class="imagen">
                <label for="logo-trabajo"><?php _e('Logo de trabajo', 'os_perfil_type'); ?></label>
                <img id="show_loto" draggable="false" alt="" name="show_loto" src="<?php if (!empty($logoTrabajo_thumbnail)) echo esc_attr($logoTrabajo_thumbnail); ?>" style="<?php if (empty($logoTrabajo_thumbnail)) echo "display: none;"; ?>">
                <div class="centered">
                    <input class="widefat" id="logo-trabajo" name="logo-trabajo" type="text" value="<?php if (!empty($logoTrabajo)) echo $logoTrabajo; ?>" readonly="readonly"/>
                    <input id="upload_loto" name="upload_loto" type="button" value="<?php _e('Explorar/Subir', 'os_perfil_type'); ?>" />
                </div>
            </div>

            <p>
                <label for="enlace-linkedin" class="autor-row-title"><?php _e('Enlace Linkedin', 'os_perfil_type' )?></label>
                <input type="text" name="enlace-linkedin" id="enlace-linkedin" value="<?php if ( $enlaceLinkedin !== '' ) echo $enlaceLinkedin[0]; ?>" />
            </p>

            <p>
                <label for="email" class="autor-row-title"><?php _e('Email', 'os_perfil_type' )?></label>
                <input type="text" name="email" id="email" value="<?php if ( $email !== '' ) echo $email[0]; ?>" />
            </p>

            <p>
                <label for="web" class="autor-row-title"><?php _e('Web', 'os_perfil_type' )?></label>
                <input type="text" name="web" id="web" value="<?php if ( $web !== '' ) echo $web[0]; ?>" />
            </p>

            <div class="imagen">
                <label for="foto-grande"><?php _e('Foto grande', 'os_perfil_type'); ?></label>
                <img id="show_foto_grande" draggable="false" alt="" name="show_foto_grande" src="<?php if (!empty($fotoGrande_thumbnail)) echo esc_attr($fotoGrande_thumbnail); ?>" style="<?php if (empty($fotoGrande_thumbnail)) echo "display: none;"; ?>">
                <div class="centered">
                    <input class="widefat" id="foto-grande" name="foto-grande" type="text" value="<?php if (!empty($fotoGrande)) echo $fotoGrande; ?>" readonly="readonly"/>
                    <input id="upload_foto_grande" name="upload_foto_grande" type="button" value="<?php _e('Explorar/Subir', 'os_perfil_type'); ?>" />
                </div>
                <label for="frase-foto-grande" class="normal autor-row-title"><?php _e('Frase', 'os_perfil_type' )?></label>
                <input type="text" name="frase-foto" id="frase-foto-grande" value="<?php if ( $fraseFotoGrande !== '' ) echo $fraseFotoGrande[0]; ?>" />
            </div>

            <p>
                <label for="area-expertise-1" class="autor-row-title"><?php _e('Área expertise 1', 'os_perfil_type' )?></label>
                <input type="text" name="web" id="area-expertise-1" value="<?php if ( $areaExpertise1 !== '' ) echo $areaExpertise1[0]; ?>" />
            </p>
            <p>
                <label for="area-expertise-2" class="autor-row-title"><?php _e('Área expertise 2', 'os_perfil_type' )?></label>
                <input type="text" name="web" id="area-expertise-2" value="<?php if ( $areaExpertise2 !== '' ) echo $areaExpertise3[0]; ?>" />
            </p>
            <p>
                <label for="area-expertise-3" class="autor-row-title"><?php _e('Área expertise 3', 'os_perfil_type' )?></label>
                <input type="text" name="web" id="area-expertise-3" value="<?php if ( $areaExpertise3 !== '' ) echo $areaExpertise2[0]; ?>" />
            </p>
         
            <?php

        }

        function detalles_asesor_meta_box_callback($post) {
            wp_nonce_field( basename( __FILE__ ), 'detalles-asesor-nonce' );
            $fotoPerfil = get_post_meta( $post->ID, 'asesor-foto-perfil' );
            $fotoPerfil_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($fotoPerfil));
            $lugarTrabajo = get_post_meta( $post->ID, 'asesor-lugar-trabajo' );

            ?>
         

            <div class="imagen">
                <label for="asesor-foto-perfil"><?php _e('Foto de perfil', 'os_perfil_type'); ?></label>
                <img id="show_foto_asesor" draggable="false" alt="" name="show_foto" src="<?php if (!empty($fotoPerfil_thumbnail)) echo esc_attr($fotoPerfil_thumbnail); ?>" style="<?php if (empty($fotoPerfil_thumbnail)) echo "display: none;"; ?>">
                <div class="centered">
                    <input class="widefat" id="asesor-foto-perfil" name="asesor-foto-perfil" type="text" value="<?php if (!empty($fotoPerfil)) echo $fotoPerfil; ?>" readonly="readonly"/>
                    <input id="upload_foto_asesor" name="upload_foto" type="button" value="<?php _e('Explorar/Subir', 'os_perfil_type'); ?>" />
                </div>
            </div>

            <p>
                <label for="asesor-lugar-trabajo" class="autor-row-title"><?php _e( 'Lugar de trabajo', 'os_perfil_type' )?></label>
                <input type="text" name="asesor-lugar-trabajo" id="asesor-lugar-trabajo" value="<?php if ( $lugarTrabajo !== '' ) echo $lugarTrabajo[0]; ?>" />
            </p>
         
            <?php

        }        
        
         function vt_meta_box_callback($post) {
            wp_nonce_field( basename( __FILE__ ), 'vt-nonce' );
            $link = get_post_meta( $post->ID, 'meta-video-testimony' );
            $mask = get_post_meta( $post->ID, 'meta-video-mask' );
            ?>
         
            <span><?php _e( 'Link to the video testimony' , 'os_perfil_type' )?></span>
            <p>
                <label for="meta-video-testimony" class="autor-row-title"><?php _e( 'Link', 'os_perfil_type' )?></label>
                <input type="text" name="meta-video-testimony" id="meta-video-testimonye" value="<?php if ( $link !== '') echo $link[0]; ?>" />
            </p>
            <p>
                <label for="meta-video-mask" class="image-row-title"><?php _e( 'Mask', 'os_perfil_type' )?></label>
                <input class="widefat" id="meta-video-mask" name="meta-video-mask" type="text" value="<?php if ( isset($mask) ) echo $mask[0]; ?>" />
            </p>
            <p>
                <input id="upload_mask" name="upload_mask" type="button" value="Explore/Upload" />
            </p>
         
            <?php
        }

        function featured_meta_box_callback($post) {
            wp_nonce_field( basename( __FILE__ ), 'featured-nonce' );
            $featured_stored_meta = get_post_meta( $post->ID, 'featured-testimony' );

            $checked = $this->check_featured_testimonies($post->ID,$featured_stored_meta[0]);
            // No se puede marcar un evento como Featured si ya hay otro 
            $disabled = $checked[1];
            ?>
            
            <p>
                <span class="featured-row-title"><?php _e( 'If checked, this testimony will be showed at first. There can only be one event labeled as \'Featured\'', 'os_perfil_type' )?></span>
                <div class="featured-row-content">
                    <label for="meta-radio-yes">
                        <input type="radio" name="featured-testimony" <?php echo $disabled ?> id="meta-radio-yes" value="yes" <?php if ( isset ( $featured_stored_meta[0] ) ) checked( $featured_stored_meta[0], 'yes' ); ?>>
                        <?php _e( 'Yes', 'os_perfil_type' )?>
                    </label>
                    <label for="meta-radio-no">
                        <input type="radio" name="featured-testimony" <?php echo $disabled ?> id="meta-radio-no" value="no" <?php if ( isset ( $featured_stored_meta[0] ) ) { checked( $featured_stored_meta[0], 'no' ); } else {checked(1,1);}; ?>>
                        <?php _e( 'No', 'os_perfil_type' )?>
                    </label>
                </div>
                <?php if($disabled === "disabled") {
                        $title = get_the_title($checked[0]);
                        print("<div class=\"notice-message\">" . __("Testimony with title \"","os_perfil_type") . $title . __("\" has been labeled as Featured. Please, first uncheck it if you want to mark this testimony as Featured",'os_perfil_type') . "</div>");
                    }
                    ?>
            </p>
         
            <?php
        }

        function meta_boxes_save($post_id) {
        	if( $this->user_can_save( $post_id, 'autor-nonce' ) ) {
                // Checks for input and saves if needed
                if( isset( $_POST[ 'meta-autor-nombre' ] ) ) {
                    update_post_meta( $post_id, 'meta-autor-nombre', $_POST[ 'meta-autor-nombre' ] );
                }
                if( isset( $_POST[ 'meta-autor-estudios' ] ) ) {
                    update_post_meta( $post_id, 'meta-autor-estudios', $_POST[ 'meta-autor-estudios' ] );
                }
            }
            
            if( $this->user_can_save( $post_id, 'detalles-asesor-nonce' ) ) {
            	if( isset( $_POST[ 'asesor-foto-perfil' ] ) ) {
                    update_post_meta( $post_id, 'asesor-foto-perfil', $_POST[ 'asesor-foto-perfil' ] );
                }
                if( isset( $_POST[ 'asesor-lugar-trabajo' ] ) ) {
                    update_post_meta( $post_id, 'asesor-lugar-trabajo', $_POST[ 'asesor-lugar-trabajo' ] );
                }
            }

            if( $this->user_can_save( $post_id, 'tipo-nonce' ) ) {
                if( isset( $_POST[ 'tipo-perfil' ] ) ) {
                    update_post_meta( $post_id, 'tipo-perfil', $_POST[ 'tipo-perfil' ] );
                } else {
                    delete_post_meta( $post_id, 'tipo-perfil', $_POST[ 'tipo-perfil' ] );
                }
            }

            if( $this->user_can_save( $post_id, 'vt-nonce' ) ) {
            	if( isset( $_POST[ 'meta-video-testimony' ] ) ) {
                    update_post_meta( $post_id, 'meta-video-testimony', $_POST[ 'meta-video-testimony' ] );
                }
                if( isset( $_POST[ 'meta-video-mask' ] ) ) {
                    update_post_meta( $post_id, 'meta-video-mask', $_POST[ 'meta-video-mask' ] );
                }
            }

            if( $this->user_can_save( $post_id, 'featured-nonce' ) ) {
                // Checks for input and saves if needed
                if( isset( $_POST[ 'featured-testimony' ] ) ) {
                    update_post_meta( $post_id, 'featured-testimony', $_POST[ 'featured-testimony' ] );
                }
            }
        }

        function register_admin_styles(){
            global $typenow;
            if($typenow == $this->post_type) {
                wp_enqueue_style( 'os_perfil_css', plugin_dir_url( __FILE__ ) . 'css/os-perfil.css' );               
            }
        }

        public function register_admin_scripts() {
            global $typenow;
            if( $typenow == $this->post_type) {
                wp_enqueue_media();
           
                wp_enqueue_script('os_perfil_validate', plugins_url( 'js/jquery.validate.min.js' , __FILE__ ), array('jquery'));
                wp_enqueue_script('os_perfil_js', plugins_url( 'js/os-perfil.js' , __FILE__ ));
            }
        }

        ////////////// MANEJO DE COLUMNAS DE LA ADMINISTRACIÓN ///////////////////

        function edit_testimonies_columns($columns) {
            $new_columns = array(
                'test-author' => __('Person information', 'os_perfil_type'),
                'featured' => __('Featured', 'os_perfil_type'),
            );
            return array_merge($columns, $new_columns);
        }

        function manage_testimonies_columns( $column, $post_id ) {
            global $post;

            switch( $column ) {

                /* If displaying the 'featured' column. */
                case 'featured' :

                    /* Get the post meta. */
                    $featured = get_post_meta( $post_id, 'featured-testimony', true );

                    if ( empty( $featured ) )
                        echo __('No');
                    else
                        printf(__('%s', 'os_perfil_type'), ucfirst($featured));
                    break;

                case 'test-author' :

                    /* Get the post meta. */
                    $author_name = get_post_meta( $post_id, 'meta-autor-nombre', true );
                    $author_estudios = get_post_meta( $post_id, 'meta-autor-estudios', true );

                    if ( empty( $author_name ) )
                        echo __('-');
                    else
                        printf(__('%s - %s', 'os_perfil_type'), $author_name, $author_estudios);
                    break;

                /* Just break out of the switch statement for everything else. */
                default :
                    break;
            }
        }

        function testimonies_sortable_columns($columns) {
            $columns['featured'] = 'featured';
            $columns['test-author'] = 'test-author';

            return $columns;
        }

        function edit_testimonies_load() {
            add_filter('request', array(&$this, 'sort_testimonies'));
        }

        function sort_testimonies($vars) {
            /* Check if we're viewing the 'movie' post type. */
            if ( isset( $vars['post_type'] ) && $this->post_type == $vars['post_type'] ) {

                /* Check if 'orderby' is set to 'featured'. */
                if ( isset( $vars['orderby'] ) && 'featured' == $vars['orderby'] ) {

                    /* Añadimos los post que no tengan el meta_key para que también salgan al ordenarlos */
                    $meta_query =  array(
                        'relation' => 'OR',
                        array(
                            'key' => 'featured-testimony',
                            'compare' => 'NOT EXISTS',
                            'value' => '',
                        )
                    );

                    /* Merge the query vars with our custom variables. */
                    $vars = array_merge(
                        $vars,
                        array(
                            'meta_query' => $meta_query,
                            'meta_key' => 'featured-testimony',
                            'orderby' => 'meta_value'
                        )
                    );
                }

                /* Check if 'orderby' is set to 'featured'. */
                if ( isset( $vars['orderby'] ) && 'test-author' == $vars['orderby'] ) {

                    /* Añadimos los post que no tengan el meta_key para que también salgan al ordenarlos */
                    $meta_query =  array(
                        'relation' => 'OR',
                        array(
                            'key' => 'meta-autor-nombre',
                            'compare' => 'NOT EXISTS',
                            'value' => '',
                        )
                    );

                    /* Merge the query vars with our custom variables. */
                    $vars = array_merge(
                        $vars,
                        array(
                            'meta_query' => $meta_query,
                            'meta_key' => 'meta-autor-nombre',
                            'orderby' => 'meta_value'
                        )
                    );
                }
            }

            return $vars;

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

        /*
        * Comprueba si ya hay un testimonio marcado como Featured y además, en caso afirmativo, devuelve su post id.
        */
        private function check_featured_testimonies($post_id,$featured) {
            global $wpdb;
            $featured = array();
            $blog_id = get_current_blog_id();
            $table = $wpdb->prefix . "postmeta";
            /*if($blog_id !== 1) {
                $table = "wp_" . $blog_id . "_postmeta";
            }*/

            $results = $wpdb->get_results("SELECT post_id FROM $table WHERE meta_key='featured-testimony' AND meta_value='yes'");
            if(!empty($results)) {
                $result = $results[0];
                $featured[0] = $result->post_id;
                if($result->post_id == $post_id) {
                    $featured[1] = "";
                    return $featured;
                }
                $results = $wpdb->get_results("SELECT post_id FROM $table WHERE meta_key='_wp_trash_meta_status' AND post_id=$featured[0]");
	            // Si no está en la Papelera, no te deja modificar el campo Featured
	            if(empty($results)) {
	            	$featured[1] = "disabled";
	            } else {
	            	$featured[1] = "";
	            }
	            return $featured;
            } else {
                $featured[1] = "";
                return $featured;
            }
            
            $featured[1] = "disabled";
            return $featured;
        }


    }

    $osTestimony = new PerfilCustomType();

endif;

?>

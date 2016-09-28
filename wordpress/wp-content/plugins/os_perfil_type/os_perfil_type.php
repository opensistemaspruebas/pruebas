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
                'rewrite' => array('slug' => 'perfil'),
                //'menu_position' => 4,
                'menu_icon' =>  'dashicons-id',
                'supports' => array("title", "editor"),
                )
            );
        }

        /**
         * Añade los meta-boxes al tipo de post Awards
         */
        function meta_boxes_add() {
            add_meta_box("t-author", __("Información básica", "os_perfil_type"), array(&$this, "author_meta_box_callback"), $this->post_type,"advanced","default");
            add_meta_box("tipo-perfil", __("Tipo de perfil", "os_perfil_type"), array(&$this, "tipo_meta_box_callback"), $this->post_type,"side","high");
            add_meta_box("detalles-miembro",__("Detalles", "os_perfil_type"),array(&$this, "detalles_miembro_meta_box_callback"),$this->post_type,"advanced","default");
            add_meta_box("detalles",__("Detalles de Asesor/Coordinador", "os_perfil_type"),array(&$this, "detalles_meta_box_callback"),$this->post_type,"advanced","default");
        }

        function author_meta_box_callback($post) {
        	wp_nonce_field( basename( __FILE__ ), 'autor-nonce' );
            $nombre = get_post_meta( $post->ID, 'meta-autor-nombre' , true);
            $cargo = get_post_meta( $post->ID, 'meta-autor-cargo' , true);
            ?>
         
            <p>
                <label for="meta-autor-nombre" class="autor-row-title"><?php _e( 'Nombre', 'os_perfil_type' )?></label>
                <input type="text" name="meta-autor-nombre" class="required" id="meta-autor-nombre" value="<?php if ( $nombre !== '') echo $nombre; ?>" />
            </p>
            <p>
                <label for="meta-autor-cargo" class="autor-row-title"><?php _e( 'Cargo', 'os_perfil_type' )?></label>
                <input type="text" name="meta-autor-cargo" class="required" id="meta-autor-cargo" value="<?php if ( $cargo !== '' ) echo $cargo; ?>" />
            </p>
         
            <?php
        }

        function tipo_meta_box_callback($post) {
            wp_nonce_field( basename( __FILE__ ), 'tipo-nonce' );
            $es_autor = get_post_meta( $post->ID, 'es-autor' , true);
            $perfil = get_post_meta( $post->ID, 'tipo-perfil' , true);
            $grupo = get_post_meta( $post->ID, 'grupo-perfil' , true);

            $posiblesCargos = array(
                'asesor' =>  __("Asesor", "os_perfil_type"),
                'coordinador' =>  __("Coordinador de grupo", "os_perfil_type"),
                'miembro' =>  __("Miembro de grupo", "os_perfil_type"),
                'speaker' => __("Speaker", "os_perfil_type"),
                'no-perfil' => __("Sin perfil adicional", "os_perfil_type"));

            /*$posiblesGrupos = array(
                'singrupo' => __("Sin grupo", "os_perfil_type"),
                'consejo-asesor' => __("Consejo asesor", "os_perfil_type"),
                'trabajo' => __("Comité de trabajo", "os_perfil_type"),
                'investigacion' => __("Grupo de investigación", "os_perfil_type"),
                'formacion' => __("Grupo de formación", "os_perfil_type"));*/

            //Dropdown of pages
            $dropdown_args = array(
                'post_type'        => 'grupo-trabajo',
                'name'             => 'grupo-perfil',
                'sort_column'      => 'menu_order, post_title',
                'selected'         =>  empty( $grupo ) ? 0 : $grupo,
                'show_option_none' => 'Sin grupo',
                'option_none_value' => 'singrupo',
                'echo'             => 0,
            );
            $pages_list = wp_dropdown_pages( $dropdown_args );

            // Imprimo checkbox autor
            $inputs .= '<p><input type="checkbox" name="es-autor" value="1" id="es-autor" ' . checked($es_autor,1,0) . ' />'.
                '<label for="es-autor"> ¿Es Autor? ' .
                '</label></p>';

            // Imprimo radio button
            foreach($posiblesCargos as $key => $label) {
                if($perfil != '') {
                    if($key == $perfil) {
                        $checked = 'checked=checked';
                    } else {
                        $checked = '';
                    }
                } else {
                    if($key == 'no-perfil') {
                        $checked = 'checked=checked';
                    }
                }
                
                $inputs .= '<input type="radio" name="tipo-perfil" value="' . esc_attr($key) . '" id="tipo-perfil[' . esc_attr($key) . ']" ' . $checked . ' />'.
                '<label for="tipo-perfil[' . esc_attr($key) . ']"> ' . esc_html($label) . ' ' .
                '</label><br>';
            }


            /*$inputs .= '<p><label for="grupo-perfil">Grupo de trabajo</label>' .
                        '<select name="grupo-perfil" id="grupo-perfil">';

            foreach ($posiblesGrupos as $key => $value) {
                $inputs .= '<option value="' . esc_attr($key) . '" ' . selected( $grupo, $key , false) . '>' . esc_html($value) . '</option>';
            }

            $inputs .= '</select></p>';*/
            $inputs .= '<p><label for="grupo-perfil">Grupo de trabajo:</label>' . $pages_list . '</p>';

            echo $inputs;

        }

        function detalles_meta_box_callback($post) {
            wp_nonce_field( basename( __FILE__ ), 'detalles-nonce' , true);

            $logoTrabajo = get_post_meta( $post->ID, 'logo-trabajo' , true);
            $logoTrabajo_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($logoTrabajo));

            $enlaceLinkedin = get_post_meta( $post->ID, 'enlace-linkedin' , true);

            $email = get_post_meta( $post->ID, 'email' , true);

            $web = get_post_meta( $post->ID, 'web' , true);

            $fotoGrande = get_post_meta( $post->ID, 'foto-grande' , true);
            $fotoGrande_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($fotoGrande));

            $fraseFotoGrande = get_post_meta( $post->ID, 'frase-foto-grande' , true);

            $areaExpertise1 = get_post_meta( $post->ID, 'area-expertise-1' , true);
            $areaExpertise2 = get_post_meta( $post->ID, 'area-expertise-2' , true);
            $areaExpertise3 = get_post_meta( $post->ID, 'area-expertise-3' , true);

            $otrosTrabajos = get_post_meta( $post->ID, 'otros-trabajos' , true);
            
            if(empty($otrosTrabajos)) {
                $otrosTrabajos = array(
                            array(
                                'titulo' => '',
                                'texto' => '',
                                'enlace' => '')
                        );
            }

            ?>
         
            <div class="imagen">
                <label for="logo-trabajo"><?php _e('Logo de trabajo', 'os_perfil_type'); ?></label>
                <img id="show_logo_emp" draggable="false" alt="" name="show_logo_emp" src="<?php if (!empty($logoTrabajo_thumbnail)) echo esc_attr($logoTrabajo_thumbnail); ?>" style="<?php if (empty($logoTrabajo_thumbnail)) echo "display: none;"; ?>">
                <div class="centered">
                    <input class="widefat" id="logo-trabajo" name="logo-trabajo" type="text" value="<?php if (!empty($logoTrabajo)) echo $logoTrabajo; ?>" readonly="readonly"/>
                    <input id="upload_logo_emp" name="upload_logo_emp" type="button" value="<?php _e('Explorar/Subir', 'os_perfil_type'); ?>" />
                </div>
            </div>

            <p>
                <label for="enlace-linkedin" class="autor-row-title"><?php _e('Enlace Linkedin', 'os_perfil_type' )?></label>
                <input type="text" name="enlace-linkedin" id="enlace-linkedin" value="<?php if ( $enlaceLinkedin !== '' ) echo $enlaceLinkedin; ?>" />
            </p>

            <p>
                <label for="email" class="autor-row-title"><?php _e('Email', 'os_perfil_type' )?></label>
                <input type="text" name="email" id="email" value="<?php if ( $email !== '' ) echo $email; ?>" />
            </p>

            <p>
                <label for="web" class="autor-row-title"><?php _e('Web', 'os_perfil_type' )?></label>
                <input type="text" name="web" id="web" value="<?php if ( $web !== '' ) echo $web; ?>" />
            </p>

            <div class="imagen">
                <label for="foto-grande"><?php _e('Foto grande', 'os_perfil_type'); ?></label>
                <img id="show_foto_grande" draggable="false" alt="" name="show_foto_grande" src="<?php if (!empty($fotoGrande_thumbnail)) echo esc_attr($fotoGrande_thumbnail); ?>" style="<?php if (empty($fotoGrande_thumbnail)) echo "display: none;"; ?>">
                <div class="centered">
                    <input class="widefat" id="foto-grande" name="foto-grande" type="text" value="<?php if (!empty($fotoGrande)) echo $fotoGrande; ?>" readonly="readonly"/>
                    <input id="upload_foto_grande" name="upload_foto_grande" type="button" value="<?php _e('Explorar/Subir', 'os_perfil_type'); ?>" />
                </div>
                <label for="frase-foto-grande" class="normal autor-row-title"><?php _e('Frase', 'os_perfil_type' )?></label>
                <input type="text" name="frase-foto-grande" id="frase-foto-grande" value="<?php if ( $fraseFotoGrande !== '' ) echo $fraseFotoGrande; ?>" />
            </div>

            <p>
                <label for="area-expertise-1" class="autor-row-title"><?php _e('Área expertise 1', 'os_perfil_type' )?></label>
                <input type="text" name="area-expertise-1" id="area-expertise-1" value="<?php if ( $areaExpertise1 !== '' ) echo $areaExpertise1; ?>" />
            </p>
            <p>
                <label for="area-expertise-2" class="autor-row-title"><?php _e('Área expertise 2', 'os_perfil_type' )?></label>
                <input type="text" name="area-expertise-2" id="area-expertise-2" value="<?php if ( $areaExpertise2 !== '' ) echo $areaExpertise2; ?>" />
            </p>
            <p>
                <label for="area-expertise-3" class="autor-row-title"><?php _e('Área expertise 3', 'os_perfil_type' )?></label>
                <input type="text" name="area-expertise-3" id="area-expertise-3" value="<?php if ( $areaExpertise3 !== '' ) echo $areaExpertise3; ?>" />
            </p>

            <div class="lista">
                <div class="titulo bold"><?php _e('Otros trabajos', 'os_perfil_type' )?></div>
                
                <?php foreach ($otrosTrabajos as $key => $otroTrab) : ?>
                    <div class="otros-trabajos">
                        
                        <div>
                            <label for="otros-trabajos[<?php echo $key ?>][titulo]" class="autor-row-title"><?php _e('Título', 'os_perfil_type' )?></label>
                            <input type="text" name="otros-trabajos[<?php echo $key ?>][titulo]" id="otros-trabajos[<?php echo $key ?>][titulo]" value="<?php if ( $otroTrab['titulo'] !== '' ) echo $otroTrab['titulo']; ?>" />
                        </div>

                        <div>
                            <label class="top" for="otros-trabajos[<?php echo $key ?>][texto]" class="autor-row-title"><?php _e('Texto', 'os_perfil_type' )?></label>
                            <textarea id="otros-trabajos[<?php echo $key; ?>][texto]" name="otros-trabajos[<?php echo $key; ?>][texto]"> <?php if ( $otroTrab['texto'] !== '' ) echo $otroTrab['texto']; ?></textarea>
                        </div>

                        <div>
                            <label for="otros-trabajos[<?php echo $key ?>][enlace]" class="autor-row-title"><?php _e('Enlace', 'os_perfil_type' )?></label>
                            <input type="text" name="otros-trabajos[<?php echo $key ?>][enlace]" id="otros-trabajos[<?php echo $key ?>][enlace]" value="<?php if ( $otroTrab['enlace'] !== '' ) echo $otroTrab['enlace']; ?>" />
                        </div>

                        <div class="alignright">
                                <a id="delete-otros-trabajos" href="javascript:void(0);">Borrar</a>
                        </div>

                    </div>
                <?php endforeach; ?>

                <p> <a id="add-otros-trabajos" href="javascript:void(0);">Añadir trabajo</a> </p>
            </div>
         
            <?php

        }

        function detalles_miembro_meta_box_callback($post) {
            wp_nonce_field( basename( __FILE__ ), 'detalles-miembro-nonce' , true);
            $fotoPerfil = get_post_meta( $post->ID, 'miembro-foto-perfil' , true);
            $fotoPerfil_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($fotoPerfil));
            $lugarTrabajo = get_post_meta( $post->ID, 'miembro-lugar-trabajo' , true);

            ?>
         

            <div class="imagen">
                <label for="miembro-foto-perfil"><?php _e('Foto de perfil', 'os_perfil_type'); ?></label>
                <img id="show_foto_miembro" draggable="false" alt="" name="show_foto" src="<?php if (!empty($fotoPerfil_thumbnail)) echo esc_attr($fotoPerfil_thumbnail); ?>" style="<?php if (empty($fotoPerfil_thumbnail)) echo "display: none;"; ?>">
                <div class="centered">
                    <input class="widefat" id="miembro-foto-perfil" name="miembro-foto-perfil" type="text" value="<?php if (!empty($fotoPerfil)) echo $fotoPerfil; ?>" readonly="readonly"/>
                    <input id="upload_foto_miembro" name="upload_foto" type="button" value="<?php _e('Explorar/Subir', 'os_perfil_type'); ?>" />
                </div>
            </div>

            <p>
                <label for="miembro-lugar-trabajo" class="autor-row-title"><?php _e( 'Lugar de trabajo', 'os_perfil_type' )?></label>
                <input type="text" name="miembro-lugar-trabajo" id="miembro-lugar-trabajo" value="<?php if ( $lugarTrabajo !== '' ) echo $lugarTrabajo; ?>" />
            </p>
         
            <?php

        }        
    

        function meta_boxes_save($post_id) {
        	if( $this->user_can_save( $post_id, 'autor-nonce' ) ) {
                // Checks for input and saves if needed
                if( isset( $_POST[ 'meta-autor-nombre' ] ) ) {
                    update_post_meta( $post_id, 'meta-autor-nombre', $_POST[ 'meta-autor-nombre' ] );
                }
                if( isset( $_POST[ 'meta-autor-cargo' ] ) ) {
                    update_post_meta( $post_id, 'meta-autor-cargo', $_POST[ 'meta-autor-cargo' ] );
                }
            }

            if( $this->user_can_save( $post_id, 'tipo-nonce' ) ) {
                if( isset( $_POST[ 'es-autor' ] ) ) {
                    update_post_meta( $post_id, 'es-autor', $_POST[ 'es-autor' ] );
                } else {
                    delete_post_meta( $post_id, 'es-autor', $_POST[ 'es-autor' ] );
                }

                if( isset( $_POST[ 'tipo-perfil' ] ) ) {
                    update_post_meta( $post_id, 'tipo-perfil', $_POST[ 'tipo-perfil' ] );
                } else {
                    delete_post_meta( $post_id, 'tipo-perfil', $_POST[ 'tipo-perfil' ] );
                }

                if( isset( $_POST[ 'grupo-perfil' ] ) ) {
                    update_post_meta( $post_id, 'grupo-perfil', $_POST[ 'grupo-perfil' ] );
                } else {
                    delete_post_meta( $post_id, 'grupo-perfil', $_POST[ 'grupo-perfil' ] );
                }
            }

            if( $this->user_can_save( $post_id, 'detalles-miembro-nonce' ) ) {
                if( isset( $_POST[ 'tipo-perfil' ] )) {
                    if( isset( $_POST[ 'miembro-foto-perfil' ] ) ) {
                        update_post_meta( $post_id, 'miembro-foto-perfil', $_POST[ 'miembro-foto-perfil' ] );
                    }
                    if( isset( $_POST[ 'miembro-lugar-trabajo' ] ) ) {
                        update_post_meta( $post_id, 'miembro-lugar-trabajo', $_POST[ 'miembro-lugar-trabajo' ] );
                    }
                } else {
                    delete_post_meta( $post_id, 'miembro-foto-perfil', $_POST[ 'miembro-foto-perfil' ] );
                    delete_post_meta( $post_id, 'miembro-lugar-trabajo', $_POST[ 'miembro-lugar-trabajo' ] );
                }
            }

            // Asesor, coordinador y speaker pueden tener ficha propia
            if( $this->user_can_save( $post_id, 'detalles-nonce' ) ) {
                if( isset( $_POST[ 'tipo-perfil' ] ) && ($_POST[ 'tipo-perfil' ] == 'asesor' || $_POST[ 'tipo-perfil' ] == 'coordinador')) {
                    if( isset( $_POST[ 'foto-perfil' ] ) ) {
                        update_post_meta( $post_id, 'foto-perfil', $_POST[ 'foto-perfil' ] );
                    }
                    if( isset( $_POST[ 'lugar-trabajo' ] ) ) {
                        update_post_meta( $post_id, 'lugar-trabajo', $_POST[ 'lugar-trabajo' ] );
                    }
                    if( isset( $_POST[ 'logo-trabajo' ] ) ) {
                        update_post_meta( $post_id, 'logo-trabajo', $_POST[ 'logo-trabajo' ] );
                    }
                    if( isset( $_POST[ 'enlace-linkedin' ] ) ) {
                        update_post_meta( $post_id, 'enlace-linkedin', $_POST[ 'enlace-linkedin' ] );
                    }
                    if( isset( $_POST[ 'email' ] ) ) {
                        update_post_meta( $post_id, 'email', $_POST[ 'email' ] );
                    }
                    if( isset( $_POST[ 'web' ] ) ) {
                        update_post_meta( $post_id, 'web', $_POST[ 'web' ] );
                    }
                    if( isset( $_POST[ 'foto-grande' ] ) ) {
                        update_post_meta( $post_id, 'foto-grande', $_POST[ 'foto-grande' ] );
                    }
                    if( isset( $_POST[ 'frase-foto-grande' ] ) ) {
                        update_post_meta( $post_id, 'frase-foto-grande', $_POST[ 'frase-foto-grande' ] );
                    }
                    if( isset( $_POST[ 'area-expertise-1' ] ) ) {
                        update_post_meta( $post_id, 'area-expertise-1', $_POST[ 'area-expertise-1' ] );
                    }
                    if( isset( $_POST[ 'area-expertise-2' ] ) ) {
                        update_post_meta( $post_id, 'area-expertise-2', $_POST[ 'area-expertise-2' ] );
                    }
                    if( isset( $_POST[ 'area-expertise-3' ] ) ) {
                        update_post_meta( $post_id, 'area-expertise-3', $_POST[ 'area-expertise-3' ] );
                    }
                    if( isset( $_POST[ 'otros-trabajos' ] ) ) {
                        $otrosTrabajos = $_POST['otros-trabajos'];
                        $nuevosTrabajos = array();
                        foreach ($otrosTrabajos as $trabajo) {
                            if (!(empty($trabajo['titulo']) && empty($trabajo['texto']) && empty($trabajo['enlace']))) {
                                array_push($nuevosTrabajos, $trabajo);
                            }
                        }
                        update_post_meta($post_id, 'otros-trabajos', $nuevosTrabajos);
                    }

                } else {
                    delete_post_meta( $post_id, 'foto-perfil', $_POST[ 'foto-perfil' ] );
                    delete_post_meta( $post_id, 'lugar-trabajo', $_POST[ 'lugar-trabajo' ] );
                    delete_post_meta( $post_id, 'logo-trabajo', $_POST[ 'logo-trabajo' ] );
                    delete_post_meta( $post_id, 'enlace-linkedin', $_POST[ 'enlace-linkedin' ] );
                    delete_post_meta( $post_id, 'email', $_POST[ 'email' ] );
                    delete_post_meta( $post_id, 'web', $_POST[ 'web' ] );
                    delete_post_meta( $post_id, 'foto-grande', $_POST[ 'foto-grande' ] );
                    delete_post_meta( $post_id, 'frase-foto-grande', $_POST[ 'frase-foto-grande' ] );
                    delete_post_meta( $post_id, 'area-expertise-1', $_POST[ 'area-expertise-1' ] );
                    delete_post_meta( $post_id, 'area-expertise-2', $_POST[ 'area-expertise-2' ] );
                    delete_post_meta( $post_id, 'area-expertise-3', $_POST[ 'area-expertise-3' ] );
                    delete_post_meta( $post_id, 'otros-trabajos', $_POST[ 'otros-trabajos' ] );
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

    $osPerfil = new PerfilCustomType();

endif;

?>

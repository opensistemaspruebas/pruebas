<?php

/*
    Plugin Name: OS Perfiles de Usuario
    Plugin URI: https://www.opensistemas.com/
    Description: Crea campos específicos para los distintos perfiles de usuario.
    Version: 1.0
    Author: Marta Oliver
    Author URI: https://www.opensistemas.com/
    License: GPLv2 or later
    Text Domain: os_perfiles_de_usuario
*/


if (!class_exists('OS_Perfiles_De_Usuario')) :


    class OS_Perfiles_De_Usuario {
        

        function __construct() {
            
            add_action('init', array(&$this, 'add_custom_user_roles'));
            add_action('init', array(&$this, 'remove_default_user_roles'));
        
            add_action('user_new_form', array(&$this, 'add_multiple_roles'), 9);
            add_action('show_user_profile', array(&$this, 'add_multiple_roles'), 9);
            add_action('edit_user_profile', array(&$this, 'add_multiple_roles'), 9);

            add_action('user_new_form', array(&$this, 'add_custom_fields'), 9);
            add_action('show_user_profile', array(&$this, 'add_custom_fields'), 9);
            add_action('edit_user_profile', array(&$this, 'add_custom_fields'), 9);

            add_action('user_register', array(&$this, 'save_custom_fields'), 10, 1);
            add_action('personal_options_update', array(&$this, 'save_custom_fields'), 9);
            add_action('edit_user_profile_update', array(&$this, 'save_custom_fields'), 9);
            
            add_action('admin_enqueue_scripts', array($this, 'load_javascript'), 10, 1);

            remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');

        }


        // Crea los roles de asesor, coordinador, miembro y ponente
        public function add_custom_user_roles() {

            $capabilities = array(
                'read'              => false,
                'edit_posts'        => false,
                'edit_pages'        => false,
                'edit_others_posts' => false,
                'create_posts'      => false,
                'manage_categories' => false,
                'publish_posts'     => false,
                'edit_themes'       => false,
                'install_plugins'   => false,
                'update_plugin'     => false,
                'update_core'        => false
            );
            
            if (!get_role('asesor'))
                add_role('asesor', __('Asesor', 'os_perfiles_de_usuario'), $capabilities );

            if (!get_role('coordinador'))
                add_role('coordinador', __('Coordinador', 'os_perfiles_de_usuario'), $capabilities );
            
            if (!get_role('miembro'))
                add_role('miembro', __('Miembro', 'os_perfiles_de_usuario'), $capabilities );
            
            if (!get_role('ponente'))
                add_role('ponente', __('Ponente', 'os_perfiles_de_usuario'), $capabilities );
        
        }
    

        // Elimina los roles de subscriptor, colaborador y editor
        public function remove_default_user_roles() {

            $roles = array('subscriber', 'contributor', 'editor');

            foreach ($roles as $role) {
                if (get_role($role)) 
                    remove_role($role);
            }
            
        }


        function add_multiple_roles( $user ) {
            // Not allowed to edit user - bail
            if (!current_user_can( 'edit_user', $user->ID ) ) {
                return;
            }
            $roles = get_editable_roles();
            $user_roles = array_intersect( array_values( $user->roles ), array_keys( $roles ) ); 

            os_imprimir($user_roles);


            ?>





            <div class="mrpu-roles-container">
                <h3><?php _e( 'User Roles', 'multiple-roles-per-user' ); ?></h3>
                <table class="form-table">
                    <tr>
                        <th><label for="user_credits"><?php _e( 'Roles', 'multiple-roles-per-user' ); ?></label></th>
                        <td>
                            <?php foreach ( $roles as $role_id => $role_data ) : ?>
                                <label for="user_role_<?php echo esc_attr( $role_id ); ?>">
                                    <input type="checkbox" id="user_role_<?php echo esc_attr( $role_id ); ?>" value="<?php echo esc_attr( $role_id ); ?>" name="mrpu_user_roles[]"<?php echo in_array( $role_id, $user_roles ) ? ' checked="checked"' : ''; ?> />
                                    <?php echo $role_data['name']; ?>
                                </label>
                                <br />
                            <?php endforeach; ?>
                            <br />
                            <span class="description"><?php _e( 'Select one or more roles for this user.', 'multiple-roles-per-user' ); ?></span>
                            <?php wp_nonce_field( 'mrpu_set_roles', '_mrpu_roles_nonce' ); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <?php 
        }

        
        // Añade campos personalizados
        public function add_custom_fields($user) { 

            if ($user !== 'add-new-user') {
                
                $user_id = $user->data->ID;
                $user_info = get_userdata($user_id);
                $nombre = $user_info->first_name;
                $apellidos = $user_info->last_name;
                $cargo = get_user_meta($user_id, 'cargo', true);
                $imagen_perfil = get_user_meta($user_id, 'imagen_perfil', true);
                $descripcion = get_user_meta($user_id, 'descripcion', true);
                $lugar_trabajo = get_user_meta($user_id, 'lugar_trabajo', true);
                $logo_trabajo = get_user_meta($user_id, 'logo_trabajo', true);
                $area_expertise_1 = get_user_meta($user_id, 'area_expertise_1', true);
                $area_expertise_2 = get_user_meta($user_id, 'area_expertise_2', true);
                $area_expertise_3 = get_user_meta($user_id, 'area_expertise_3', true);
                $linkedin = get_user_meta($user_id, 'linkedin', true);
                $correo_electronico = $user_info->user_email;
                $url_web = $user_info->url_web;
                $imagen_cabecera = get_user_meta($user_id, 'imagen_cabecera', true);
                $frase_cabecera = get_user_meta($user_id, 'frase_cabecera', true);
                $trabajos = get_user_meta($user_id, 'trabajos', true);

            } else {

                $nombre = $cargo = $imagen_perfil = $descripcion = $lugar_trabajo = $logo_trabajo = $area_expertise_1 = $area_expertise_2 = $area_expertise_3 = $linkedin = $correo_electronico = $url_web = $imagen_cabecera = $frase_cabecera = '';
                $trabajos = array();
            
            }

            ?>
            <div class="campo_personalizado" id="informacion_personal" name="informacion_personal">
                <h3><?php _e('Información personal', 'os_perfiles_de_usuario'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="nombre"><?php _e('Nombre', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="nombre" id="nombre" value="<?php echo esc_attr($nombre); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('Nombre de la persona', 'os_perfiles_de_usuario'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="apellidos"><?php _e('Apellidos', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="apellidos" id="apellidos" value="<?php echo esc_attr($apellidos); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('Apellidos de la persona', 'os_perfiles_de_usuario'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="cargo"><?php _e('Cargo/Estudios', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="cargo" id="cargo" value="<?php echo esc_attr($cargo); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('Cargo o estudios de la persona', 'os_perfiles_de_usuario'); ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="campo_personalizado" id="información_acerca_de" name="informacion_acerca_de">
                <h3><?php _e("Acerca de", "os_perfiles_de_usuario"); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="imagen_perfil"><?php _e('Imagen de perfil', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="imagen_perfil" id="imagen_perfil" value="<?php echo esc_url($imagen_perfil); ?>" class="regular-text" readonly="readonly" />
                            <input type='button' class="additional-user-image button-primary" value="<?php _e('Subir imagen', 'os_perfiles_de_usuario'); ?>" id="uploadimage"/><br />
                            <span class="description"><?php _e('Subir una imagen de perfil', 'os_perfiles_de_usuario'); ?></span>
                            <br /><br />
                            <img id="mostrar_imagen_perfil" name="mostrar_imagen_perfil" src="<?php echo esc_url($imagen_perfil); ?>" style="width:150px;<?php if (empty($imagen_perfil)) echo 'display:none;';?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="descripcion"><?php _e('Descripción', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                         <td>
                            <textarea cols="40" rows="5" name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="campo_personalizado" id="informacion_trabajo" name="informacion_trabajo">
                <h3><?php _e('Información sobre el trabajo', 'os_perfiles_de_usuario'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="lugar_trabajo"><?php _e('Lugar de trabajo', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="lugar_trabajo" id="lugar_trabajo" value="<?php echo esc_attr($lugar_trabajo); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('Nombre del lugar de trabajo', 'os_perfiles_de_usuario'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="logo_trabajo"><?php _e('Logo de trabajo', ''); ?></label>
                        </th>
                        <td>
                            <input type="text" name="logo_trabajo" id="logo_trabajo" value="<?php echo esc_url($logo_trabajo); ?>" class="regular-text" readonly="readonly" />
                            <input type='button' class="additional-trabajo-image button-primary" value="<?php _e('Subir imagen', 'os_perfiles_de_usuario'); ?>" id="uploadimage"/><br />
                            <span class="description"><?php _e('Subir logo de trabajo', 'os_perfiles_de_usuario'); ?></span>
                            <br /><br />
                            <img id="mostrar_imagen_trabajo" name="mostrar_imagen_trabajo" src="<?php echo esc_url($logo_trabajo); ?>" style="width:150px;<?php if (empty($logo_trabajo)) echo 'display:none;';?>">
                        </td>
                    </tr>
                </table>
            </div>

            <div class="campo_personalizado" id="informacion_expertise" name="informacion_expertise">
                <h3><?php _e('Áreas de expertise', 'os_perfiles_de_usuario'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="area_expertise_1"><?php _e('Área de expertise 1', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="area_expertise_1" id="area_expertise_1" value="<?php echo esc_attr($area_expertise_1); ?>" class="regular-text" /><br />
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="area_expertise_2"><?php _e('Área de expertise 2', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="area_expertise_2" id="area_expertise_2" value="<?php echo esc_attr($area_expertise_2); ?>" class="regular-text" /><br />
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="area_expertise_3"><?php _e('Área de expertise 3', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="area_expertise_3" id="area_expertise_3" value="<?php echo esc_attr($area_expertise_3); ?>" class="regular-text" /><br />
                        </td>
                    </tr>
                </table>
            </div>

            <div class="campo_personalizado" id="informacion_contacto" name="informacion_contacto">
                <h3><?php _e('Información de contacto', 'os_perfiles_de_usuario'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="linkedin"><?php _e('LinkedIn', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr($linkedin); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('URL de perfil de LinkedIn', 'os_perfiles_de_usuario'); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="correo_electronico"><?php _e('Correo electrónico', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="correo_electronico" id="linkedin" value="<?php echo esc_attr($correo_electronico); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('Dirección de correo electrónico', 'os_perfiles_de_usuario'); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="url_web"><?php _e('Web', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="url_web" id="linkedin" value="<?php echo esc_attr($url_web); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('URL de la página web de la persona', 'os_perfiles_de_usuario'); ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="campo_personalizado" id="informacion_cabecera" name="informacion_cabecera">
                <h3><?php _e('Información de cabecera', 'os_perfiles_de_usuario'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="imagen_cabecera"><?php _e('Imagen de cabecera', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="imagen_cabecera" id="imagen_cabecera" value="<?php echo esc_url($imagen_cabecera); ?>" class="regular-text" readonly="readonly" />
                            <input type='button' class="additional-cabecera-image button-primary" value="<?php _e('Subir imagen', 'os_perfiles_de_usuario'); ?>" id="uploadimagecabecera"/><br />
                            <span class="description"><?php _e('Subir una imagen para la cabecera de la página de perfil', 'os_perfiles_de_usuario'); ?></span>
                            <br /><br />
                            <img id="mostrar_imagen_cabecera" name="mostrar_imagen_cabecera" src="<?php echo esc_url($imagen_cabecera); ?>" style="width:150px;<?php if (empty($imagen_cabecera)) echo 'display:none;';?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="frase_cabecera"><?php _e('Frase para la cabecera', 'os_perfiles_de_usuario'); ?></label>
                        </th>
                         <td>
                            <textarea cols="40" rows="5" name="frase_cabecera" id="frase_cabecera"><?php echo esc_attr($frase_cabecera); ?></textarea><br />
                            <span class="description"><?php _e('Frase para la cabecera de la página de perfil', 'os_perfiles_de_usuario'); ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="campo_personalizado" id="informacion_trabajos_relacionados" name="informacion_trabajos_relacionados">
                <h3><?php _e('Trabajos relacionados', 'os_perfiles_de_usuario'); ?></h3>
                <?php if (empty($trabajos)) : ?>
                    <div style="border: 3px solid white;padding: 5px;margin-bottom: 10px;">
                        <table class="form-table">
                            <tr>
                                <th>
                                    <label for="trabajos[0][titulo]"><?php _e('Trabajo relacionado', 'os_perfiles_de_usuario'); ?></label>
                                </th>
                                 <td>
                                    <input type="text" name="trabajos[0][titulo]" id="trabajos[0][titulo]" value="" class="regular-text" /><br />
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="trabajos[0][texto]"><?php _e('Descripción', 'os_perfiles_de_usuario'); ?></label>
                                </th>
                                 <td>
                                    <textarea id="trabajos[0][texto]" name="trabajos[0][texto]" rows="5" cols="40"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="trabajos[0][enlace]"><?php _e('Enlace al trabajo', 'os_perfiles_de_usuario'); ?></label>
                                </th>
                                 <td>
                                    <input type="url" name="trabajos[0][enlace]" id="trabajos[0][enlace]" value="" class="regular-text" /><br />
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php else : ?>
                    <?php $i = 0; ?>
                    <?php foreach ($trabajos as $trabajo) : ?>
                        <div class="campo_personalizado" style="border: 3px solid white;padding: 5px;margin-bottom: 10px;">
                            <table class="form-table">
                                <tr>
                                    <th>
                                        <label for="trabajos[<?php echo $i; ?>][titulo]"><?php _e('Trabajo relacionado', 'os_perfiles_de_usuario'); ?></label>
                                    </th>
                                     <td>
                                        <input type="text" name="trabajos[<?php echo $i; ?>][titulo]" id="trabajos[<?php echo $i; ?>][titulo]" value="<?php echo $trabajo['titulo']; ?>" class="regular-text" /><br />
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="trabajos[<?php echo $i; ?>][texto]"><?php _e('Descripción', 'os_perfiles_de_usuario'); ?></label>
                                    </th>
                                     <td>
                                        <textarea id="trabajos[<?php echo $i; ?>][texto]" name="trabajos[<?php echo $i; ?>][texto]" rows="5" cols="40"><?php echo $trabajo['texto']; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="trabajos[<?php echo $i; ?>][enlace]"><?php _e('Enlace al trabajo', 'os_perfiles_de_usuario'); ?></label>
                                    </th>
                                     <td>
                                        <input type="url" name="trabajos[<?php echo $i; ?>][enlace]" id="trabajos[<?php echo $i; ?>][enlace]" value="<?php echo $trabajo['enlace']; ?>" class="regular-text" /><br />
                                    </td>
                                </tr>
                            </table>
                            <?php if ($i > 0) : ?>
                                <button id="delete-trabajo" type="button"><?php _e('Eliminar este trabajo', 'os_perfiles_de_usuario'); ?></button>
                            <?php endif; ?>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <p>
                    <button id="add-trabajo" type="button"><?php _e('Añadir trabajo', 'os_perfiles_de_usuario')?></button>
                </p>
            </div>
            <?php
        
        }


        // Guarda campos personalizados
        public function save_custom_fields($user_id) {

            if (isset($_POST['nombre'])) {
                wp_update_user(array('ID' => $user_id, 'first_name' => esc_attr($_POST['nombre'])));
            }

            if (isset($_POST['apellidos'])) {
                wp_update_user(array('ID' => $user_id, 'last_name' => esc_attr($_POST['apellidos'])));
            }

            if (isset($_POST['cargo'])) {
                update_user_meta($user_id, 'cargo', $_POST['cargo']);
            }

            if (isset($_POST['imagen_perfil'])) {
                update_user_meta($user_id, 'imagen_perfil', $_POST['imagen_perfil']);
            }

            if (isset($_POST['descripcion'])) {
                update_user_meta($user_id, 'descripcion', $_POST['descripcion']);
            }

            if (isset($_POST['lugar_trabajo'])) {
                update_user_meta($user_id, 'lugar_trabajo', $_POST['lugar_trabajo']);
            }

            if (isset($_POST['logo_trabajo'])) {
                update_user_meta($user_id, 'logo_trabajo', $_POST['logo_trabajo']);
            }

            if (isset($_POST['area_expertise_1'])) {
                update_user_meta($user_id, 'area_expertise_1', $_POST['area_expertise_1']);
            }

            if (isset($_POST['area_expertise_2'])) {
                update_user_meta($user_id, 'area_expertise_2', $_POST['area_expertise_2']);
            }

            if (isset($_POST['area_expertise_3'])) {
                update_user_meta($user_id, 'area_expertise_3', $_POST['area_expertise_3']);
            }

            if (isset($_POST['linkedin'])) {
                update_user_meta($user_id, 'linkedin', $_POST['linkedin']);
            }

            if (isset($_POST['correo_electronico'])) {
                wp_update_user(array('ID' => $user_id, 'user_login' => esc_attr($_POST['correo_electronico'])));
                wp_update_user(array('ID' => $user_id, 'email' => esc_attr($_POST['correo_electronico'])));
            } else if ($_POST['rol'] !== "administrator") {
                $correo_dummy = 'dummy_' . $user_id . "@dummy.com";
                wp_update_user(array('ID' => $user_id, 'user_login' => esc_attr($correo_dummy)));
                wp_update_user(array('ID' => $user_id, 'email' => esc_attr($correo_dummy)));
            }

            if (isset($_POST['url_web'])) {
                wp_update_user(array('ID' => $user_id, 'url_web' => esc_attr($_POST['url_web'])));
            }

            if (isset($_POST['imagen_cabecera'])) {
                update_user_meta($user_id, 'imagen_cabecera', $_POST['imagen_cabecera']);
            }

            if (isset($_POST['frase_cabecera'])) {
                update_user_meta($user_id, 'frase_cabecera', $_POST['frase_cabecera']);
            }

            if (isset($_POST['trabajos'])) {
                $trabajos = $_POST['trabajos'];
                $trabajos_nuevos = array();
                foreach ($trabajos as $trabajo) {
                    if (!(empty($trabajo['titulo']))) {
                        array_push($trabajos_nuevos, $trabajo);
                    }
                }
                update_user_meta($user_id, 'trabajos', $trabajos_nuevos);
            }

            
            error_log(print_r($_POST['mrpu_user_roles'], true));


            $roles = get_editable_roles();
            $new_roles = isset( $_POST['mrpu_user_roles']) ? (array) $_POST['mrpu_user_roles'] : array();
            $new_roles = array_intersect( $new_roles, array_keys( $roles ) );
            $roles_to_remove = array();
            $user_roles = array_intersect( array_values( $user->roles ), array_keys( $roles ) );
            if ( ! $new_roles ) {
                // If there are no roles, delete all of the user's roles
                $roles_to_remove = $user_roles;
            } else {
                $roles_to_remove = array_diff( $user_roles, $new_roles );
            }
            foreach ( $roles_to_remove as $_role ) {
                $user->remove_role( $_role );
            }
            if ( $new_roles ) {
                // Make sure that we don't call $user->add_role() any more than it's necessary
                $_new_roles = array_diff( $new_roles, array_intersect( array_values( $user->roles ), array_keys( $roles ) ) );
                foreach ( $_new_roles as $_role ) {
                    $user->add_role( $_role );
                }
            }
         
        }


        // Carga js
        public function load_javascript($hook) {

            if (!current_user_can('edit_posts'))
                return;

            if ($hook == 'user-new.php' || $hook == 'profile.php' || $hook == 'user-edit.php') {
                wp_enqueue_script('os_perfiles_de_usuario', plugins_url('js/os_perfiles_de_usuario.js', __FILE__), array('jquery'));
            }
        
        }


    } 


endif;

$os_perfiles_de_usuario = new OS_Perfiles_De_Usuario();
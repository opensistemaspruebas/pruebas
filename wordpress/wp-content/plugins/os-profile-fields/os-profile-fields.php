<?php

/*
    Plugin Name: OS Profile Fields
    Description: Filtros y acciones para personalizar los campos de perfil de usuario
    Version: 1.0
    Author: Carlos Mendoza
    Author URI: http://www.opensistemas.com/
 */


if (!class_exists('OSProfileFields')) :

    class OSProfileFields {
        
        private $name = "OS Profile Fields";

        static $uniqueObject = null;

        static function & getInstance() {

            if (null == OSProfileFields::$uniqueObject) {
                OSProfileFields::$uniqueObject = new OSProfileFields();
            }

            return OSProfileFields::$uniqueObject;
        }

        function __construct() {

            add_action('user_new_form', array(&$this, 'anadir_campos'), 9);
            add_action('show_user_profile', array(&$this, 'anadir_campos'), 9);
            add_action('edit_user_profile', array(&$this, 'anadir_campos'), 9);
            add_action('personal_options_update', array(&$this, 'guardar_campos'), 9);
            add_action('edit_user_profile_update', array(&$this, 'guardar_campos'), 9);

            
            add_action('admin_enqueue_scripts', array($this, 'load_javascript'), 10, 1);

        }


        function guardar_campos($user_id) {
            
            if (isset($_POST['nombre'])) {
                update_user_meta($user_id, 'nombre', $_POST['nombre']);
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
                update_user_meta($user_id, 'correo_electronico', $_POST['correo_electronico']);
            }

            if (isset($_POST['url_web'])) {
                update_user_meta($user_id, 'url_web', $_POST['url_web']);
            }

            if (isset($_POST['imagen_cabecera'])) {
                update_user_meta($user_id, 'imagen_cabecera', $_POST['imagen_cabecera']);
            }

            if (isset($_POST['frase_cabecera'])) {
                update_user_meta($user_id, 'frase_cabecera', $_POST['frase_cabecera']);
            }

            // Faltan trabajos relacionados!!!!!!
         
        }


        public function load_javascript($hook) {

            if (!current_user_can('edit_posts'))
                return;

            if ($hook == 'user-new.php' || $hook == 'profile.php' || $hook == 'user-edit.php') {
                wp_enqueue_script('os_profile_fields', plugins_url('js/os_profile_fields.js', __FILE__), array('jquery'));
            }
        
        }


        function anadir_campos($user) { ?>

            <?php

                if ($user !== 'add-new-user') {
                    $user_id = $user->data->ID;
        
                }

            ?>

            <?php list_roles(); ?>

            <div id="informacion_personal" name="informacion_personal">
                <h3><?php _e('Información personal', 'os_profile_fields'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="nombre"><?php _e('Nombre', 'os_profile_fields'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="nombre" id="nombre" value="<?php echo esc_attr($nombre); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('Nombre y apellidos de la persona', 'os_profile_fields'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="cargo"><?php _e('Cargo/Estudios', 'os_profile_fields'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="cargo" id="cargo" value="<?php echo esc_attr($cargo); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('Cargo o estudios de la persona', 'os_profile_fields'); ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="información_acerca_de" name="informacion_acerca_de">
                <h3><?php _e("Acerca de", "os_profile_fields"); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="imagen_perfil"><?php _e('Imagen de perfil', ''); ?></label>
                        </th>
                        <td>
                            <input type="text" name="imagen_perfil" id="imagen_perfil" value="<?php echo esc_url_raw( get_the_author_meta('imagen_perfil', $user->ID)); ?>" class="regular-text" disabled="disabled" />
                            <input type='button' class="additional-user-image button-primary" value="<?php _e('Subir imagen', 'os_profile_fields'); ?>" id="uploadimage"/><br />
                            <span class="description"><?php _e('Subir una imagen de perfil', 'os_profile_fields'); ?></span>
                            <br /><br />
                            <img id="mostrar_imagen_perfil" name="mostrar_imagen_perfil" src="<?php echo esc_url(get_the_author_meta('imagen_perfil', $user->ID)); ?>" style="width:150px;display:none;">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="descripcion"><?php _e('Descripción', 'os_profile_fields'); ?></label>
                        </th>
                         <td>
                            <textarea cols="40" rows="5" name="descripcion" id="descripcion"><?php echo ''; ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="informacion_trabajo" name="informacion_trabajo">
                <h3><?php _e('Información sobre el trabajo', 'os_profile_fields'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="lugar_trabajo"><?php _e('Lugar de trabajo', 'os_profile_fields'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="lugar_trabajo" id="lugar_trabajo" value="<?php echo esc_attr($lugar_trabajo); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('Nombre del lugar de trabajo', 'os_profile_fields'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="logo_trabajo"><?php _e('Logo de trabajo', ''); ?></label>
                        </th>
                        <td>
                            <input type="text" name="logo_trabajo" id="logo_trabajo" value="<?php echo esc_url_raw( get_the_author_meta('logo_trabajo', $user->ID)); ?>" class="regular-text" disabled="disabled" />
                            <input type='button' class="additional-trabajo-image button-primary" value="<?php _e('Subir imagen', 'os_profile_fields'); ?>" id="uploadimage"/><br />
                            <span class="description"><?php _e('Subir logo de trabajo', 'os_profile_fields'); ?></span>
                            <br /><br />
                            <img id="mostrar_imagen_trabajo" name="mostrar_imagen_trabajo" src="<?php echo esc_url(get_the_author_meta('logo_trabajo', $user->ID)); ?>" style="width:150px;display:none;">
                        </td>
                    </tr>
                </table>
            </div>

            <div id="informacion_expertise" name="informacion_expertise">
                <h3><?php _e('Áreas de expertise', 'os_profile_fields'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="area_expertise_1"><?php _e('Área de expertise 1', 'os_profile_fields'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="area_expertise_1" id="area_expertise_1" value="<?php echo esc_attr($area_expertise_1); ?>" class="regular-text" /><br />
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="area_expertise_2"><?php _e('Área de expertise 2', 'os_profile_fields'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="area_expertise_2" id="area_expertise_2" value="<?php echo esc_attr($area_expertise_2); ?>" class="regular-text" /><br />
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="area_expertise_3"><?php _e('Área de expertise 3', 'os_profile_fields'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="area_expertise_3" id="area_expertise_3" value="<?php echo esc_attr($area_expertise_3); ?>" class="regular-text" /><br />
                        </td>
                    </tr>
                </table>
            </div>

            <div id="informacion_contacto" name="informacion_contacto">
                <h3><?php _e('Información de contacto', 'os_profile_fields'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="linkedin"><?php _e('LinkedIn', 'os_profile_fields'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr($linkedin); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('URL de perfil de LinkedIn', 'os_profile_fields'); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="correo_electronico"><?php _e('Correo electrónico', 'os_profile_fields'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="correo_electronico" id="linkedin" value="<?php echo esc_attr($correo_electronico); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('Dirección de correo electrónico', 'os_profile_fields'); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="url_web"><?php _e('Web', 'os_profile_fields'); ?></label>
                        </th>
                         <td>
                            <input type="text" name="url_web" id="linkedin" value="<?php echo esc_attr($url_web); ?>" class="regular-text" /><br />
                            <span class="description"><?php _e('URL de la página web de la persona', 'os_profile_fields'); ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="informacion_cabecera" name="informacion_cabecera">
                <h3><?php _e('Información de cabecera', 'os_profile_fields'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th>
                            <label for="imagen_cabecera"><?php _e('Imagen de cabecera', 'os_profile_fields'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="imagen_cabecera" id="imagen_cabecera" value="<?php echo esc_url_raw($imagen_cabecera); ?>" class="regular-text" disabled="disabled" />
                            <input type='button' class="additional-cabecera-image button-primary" value="<?php _e('Subir imagen', 'os_profile_fields'); ?>" id="uploadimagecabecera"/><br />
                            <span class="description"><?php _e('Subir una imagen para la cabecera de la página de perfil', 'os_profile_fields'); ?></span>
                            <br /><br />
                            <img id="mostrar_imagen_cabecera" name="mostrar_imagen_cabecera" src="<?php echo esc_url($mostrar_imagen_cabecera); ?>" style="width:150px;display:none;">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="frase_cabecera"><?php _e('Frase para la cabecera', 'os_profile_fields'); ?></label>
                        </th>
                         <td>
                            <textarea cols="40" rows="5" name="frase_cabecera" id="frase_cabecera"><?php echo esc_attr($frase_cabecera); ?></textarea><br />
                            <span class="description"><?php _e('Frase para la cabecera de la página de perfil', 'os_profile_fields'); ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="informacion_trabajos_relacionados" name="informacion_trabajos_relacionados">
                <h3><?php _e('Trabajos relacionados', 'os_profile_fields'); ?></h3>
                <div style="border: 3px solid white;padding: 5px;margin-bottom: 10px;">
                    <table class="form-table">
                        <tr>
                            <th>
                                <label for="trabajo_titulo[0]"><?php _e('Trabajo relacionado', 'os_profile_fields'); ?></label>
                            </th>
                             <td>
                                <input type="text" name="trabajo_titulo[0]" id="trabajo_titulo[0]" value="<?php echo esc_attr($trabajo_titulo[0]); ?>" class="regular-text" /><br />
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="trabajo_texto[0]"><?php _e('Descripción', 'os_profile_fields'); ?></label>
                            </th>
                             <td>
                                <textarea id="trabajo_texto[0]" name="trabajo_texto[0]" rows="5" cols="40"><?php echo esc_attr($trabajo_texto[0]); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="trabajo_enlace[0]"><?php _e('Enlace al trabajo', 'os_profile_fields'); ?></label>
                            </th>
                             <td>
                                <input type="url" name="trabajo_enlace[0]" id="trabajo_enlace[0]" value="<?php echo esc_attr($trabajo_enlace[0]); ?>" class="regular-text" /><br />
                            </td>
                        </tr>
                    </table>
                </div>
                <p>
                    <button id="add-trabajo" type="button"><?php _e('Añadir trabajo', 'os_profile_fields')?></button>
                </p>
            </div>

        <?php }


    }

    new OSProfileFields;
endif;


function list_roles() {

    global $wp_roles;

    if (!isset($wp_roles)) {
        $wp_roles = new WP_Roles();
    }
    
    $roles = $wp_roles->get_names();

    if (!empty($roles)) {
        echo '<div id="informacion_perfiles" name="informacion_perfiles">';
        echo '<h3>' . __('Perfiles', 'os_profile_fields') . '</h3>';
        echo '<table class="form-table">';
        echo '<tbody>';
        foreach ($roles as $role_value => $role_name) {
            echo '<tr>';
            echo '<td><input id="role_' . $role_value . '" name="role_' . $role_value . '" type="checkbox" value="' . $role_value . '"> <label for="role_' . $role_value . '">'. $role_name . '</label></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

}
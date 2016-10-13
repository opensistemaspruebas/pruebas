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


class OS_Perfiles_de_Usuario {
 

    public function __construct() {
        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox'));
            add_action('load-post-new.php', array( $this, 'init_metabox'));
            add_action('admin_enqueue_scripts', array($this, 'load_javascript'), 10, 1);
        }
 
    }
 

    public function load_javascript($hook) {

        global $post_type;

        if (!current_user_can('edit_posts'))
            return;

        if ($hook == 'post-new.php' || $hook == 'post.php') {
            if ('guest-author' == $post_type ) {
                wp_enqueue_script('os_perfiles_de_usuario_js', plugins_url('js/os_perfiles_de_usuario.js', __FILE__), array('jquery'));
                wp_enqueue_style('os_perfiles_de_usuario_css', plugins_url('css/os_perfiles_de_usuario.css', __FILE__));
            }
        }
    
    }


    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }
 

    public function add_metabox() {
        add_meta_box('my-meta-box', __( 'Campos de perfil', 'os_perfiles_de_usuario' ), array( $this, 'render_metabox' ), 'guest-author', 'advanced', 'default');
    }
 

    public function render_metabox($post) {
        wp_nonce_field('custom_nonce_action', 'custom_nonce');

        $post_id = $post->ID;

        $nombre = get_post_meta($post_id, 'cap-display_name', true);
        $cargo = get_post_meta($post_id, 'cargo', true);
        $imagen_perfil = get_post_meta($post_id, 'imagen_perfil', true);
        $descripcion = get_post_meta($post_id, 'descripcion', true);
        $lugar_trabajo = get_post_meta($post_id, 'lugar_trabajo', true);
        $logo_trabajo = get_post_meta($post_id, 'logo_trabajo', true);
        $area_expertise_1 = get_post_meta($post_id, 'area_expertise_1', true);
        $area_expertise_2 = get_post_meta($post_id, 'area_expertise_2', true);
        $area_expertise_3 = get_post_meta($post_id, 'area_expertise_3', true);
        $linkedin = get_post_meta($post_id, 'linkedin', true);
        $twitter = get_post_meta($post_id, 'twitter', true);
        $correo_electronico = get_post_meta($post_id, 'correo_electronico', true);
        $url_web = get_post_meta($post_id, 'url_web', true);
        $imagen_cabecera = get_post_meta($post_id, 'imagen_cabecera', true);
        $frase_cabecera = get_post_meta($post_id, 'frase_cabecera', true);
        $trabajos = get_post_meta($post_id, 'trabajos', true);

        $miembro = get_term_by('slug', 'miembro', 'perfil');
        $miembro_id = $miembro->term_id;
        
        $coordinador = get_term_by('slug', 'coordinador', 'perfil');
        $coordinador_id = $coordinador->term_id;
        
        $asesor = get_term_by('slug', 'asesor', 'perfil');
        $asesor_id = $asesor->term_id;
        
        $autor = get_term_by('slug', 'autor', 'perfil');
        $autor_id = $autor->term_id;
        
        $ponente = get_term_by('slug', 'ponente', 'perfil');
        $ponente_id = $ponente->term_id;

        ?>
        <div id="informacion_personal" name="informacion_personal">
            <h3><?php _e('Información personal', 'os_perfiles_de_usuario'); ?></h3>
            <table class="form-table">
                <tr>
                    <th>
                        <label for="nombre"><?php _e('Nombre', 'os_perfiles_de_usuario'); ?> <span class="description">(<?php _e('obligatorio', 'os_perfiles_de_usuario'); ?>)</span></label>
                    </th>
                    <td>
                        <input required="required" type="text" name="cap-display_name" id="cap-display_name" value="<?php echo esc_attr($nombre); ?>" class="regular-text" /><br />
                        <span class="description"><?php _e('Nombre y apellidos de la persona', 'os_perfiles_de_usuario'); ?></span>
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

        <div class="campo_personalizado <?php echo $miembro_id; ?> <?php echo $coordinador_id; ?> <?php echo $asesor_id; ?>" id="información_acerca_de" name="informacion_acerca_de">
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
                        <img id="mostrar_imagen_perfil" name="mostrar_imagen_perfil" src="<?php echo esc_url($imagen_perfil); ?>" style="width:50px;<?php if (empty($imagen_perfil)) echo 'display:none;';?>">
                    </td>
                </tr>
                <tr class="<?php echo $coordinador_id; ?> <?php echo $asesor_id; ?>">
                    <th>
                        <label for="descripcion"><?php _e('Descripción', 'os_perfiles_de_usuario'); ?></label>
                    </th>
                     <td>
                        <textarea cols="40" rows="5" name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <div class="campo_personalizado <?php echo $coordinador_id; ?> <?php echo $asesor_id; ?>" id="informacion_trabajo" name="informacion_trabajo">
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

        <div class="campo_personalizado <?php echo $coordinador_id; ?> <?php echo $asesor_id; ?>" id="informacion_expertise" name="informacion_expertise">
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

        <div class="campo_personalizado <?php echo $coordinador_id; ?> <?php echo $asesor_id; ?>" id="informacion_contacto" name="informacion_contacto">
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
                        <label for="twitter"><?php _e('Twitter', 'os_perfiles_de_usuario'); ?></label>
                    </th>
                     <td>
                        <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr($twitter); ?>" class="regular-text" /><br />
                        <span class="description"><?php _e('URL de perfil de Twitter', 'os_perfiles_de_usuario'); ?></span>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="correo_electronico"><?php _e('Correo electrónico', 'os_perfiles_de_usuario'); ?></label>
                    </th>
                     <td>
                        <input type="text" name="correo_electronico" id="correo_electronico" value="<?php echo esc_attr($correo_electronico); ?>" class="regular-text" /><br />
                        <span class="description"><?php _e('Dirección de correo electrónico', 'os_perfiles_de_usuario'); ?></span>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="url_web"><?php _e('Web', 'os_perfiles_de_usuario'); ?></label>
                    </th>
                     <td>
                        <input type="text" name="url_web" id="url_web" value="<?php echo esc_attr($url_web); ?>" class="regular-text" /><br />
                        <span class="description"><?php _e('URL de la página web de la persona', 'os_perfiles_de_usuario'); ?></span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="campo_personalizado <?php echo $coordinador_id; ?> <?php echo $asesor_id; ?>" id="informacion_cabecera" name="informacion_cabecera">
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

        <div class="campo_personalizado <?php echo $coordinador_id; ?> <?php echo $asesor_id; ?>" id="informacion_trabajos_relacionados" name="informacion_trabajos_relacionados">
            <h3><?php _e('Trabajos relacionados', 'os_perfiles_de_usuario'); ?></h3>
            <?php if (empty($trabajos)) : ?>
                <div style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;">
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
                    <div class="campo_personalizado <?php echo $miembro_id; ?> <?php echo $coordinador_id; ?> <?php echo $asesor_id; ?>" style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;">
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
 

    public function save_metabox($post_id, $post) {
        $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';
 
        if (!isset( $nonce_name ) ) {
            return;
        }
 
        if (!wp_verify_nonce( $nonce_name, $nonce_action)) {
            return;
        }

        if ( ! current_user_can('edit_post', $post_id)) {
            return;
        }
 
        if (wp_is_post_autosave($post_id)) {
            return;
        }
 
        if (wp_is_post_revision($post_id)) {
            return;
        }

        if (isset($_POST['cap-display_name'])) {
            update_post_meta($post_id, 'cap-display_name', esc_attr($_POST['cap-display_name']));
        }


        if (isset($_POST['cargo'])) {
            update_post_meta($post_id, 'cargo', $_POST['cargo']);
        }

        if (isset($_POST['imagen_perfil'])) {
            update_post_meta($post_id, 'imagen_perfil', $_POST['imagen_perfil']);
        }

        if (isset($_POST['descripcion'])) {
            update_post_meta($post_id, 'descripcion', $_POST['descripcion']);
        }

        if (isset($_POST['lugar_trabajo'])) {
            update_post_meta($post_id, 'lugar_trabajo', $_POST['lugar_trabajo']);
        }

        if (isset($_POST['logo_trabajo'])) {
            update_post_meta($post_id, 'logo_trabajo', $_POST['logo_trabajo']);
        }

        if (isset($_POST['area_expertise_1'])) {
            update_post_meta($post_id, 'area_expertise_1', $_POST['area_expertise_1']);
        }

        if (isset($_POST['area_expertise_2'])) {
            update_post_meta($post_id, 'area_expertise_2', $_POST['area_expertise_2']);
        }

        if (isset($_POST['area_expertise_3'])) {
            update_post_meta($post_id, 'area_expertise_3', $_POST['area_expertise_3']);
        }

        if (isset($_POST['linkedin'])) {
            update_post_meta($post_id, 'linkedin', $_POST['linkedin']);
        }

        if (isset($_POST['twitter'])) {
            update_post_meta($post_id, 'twitter', $_POST['twitter']);
        }

        if (isset($_POST['correo_electronico'])) {
            update_post_meta($post_id, 'correo_electronico', $_POST['correo_electronico']);
        }

        if (isset($_POST['url_web'])) {
            update_post_meta($post_id, 'url_web', $_POST['url_web']);
        }

        if (isset($_POST['imagen_cabecera'])) {
            update_post_meta($post_id, 'imagen_cabecera', $_POST['imagen_cabecera']);
        }

        if (isset($_POST['frase_cabecera'])) {
            update_post_meta($post_id, 'frase_cabecera', $_POST['frase_cabecera']);
        }

        if (isset($_POST['trabajos'])) {
            $trabajos = $_POST['trabajos'];
            $trabajos_nuevos = array();
            foreach ($trabajos as $trabajo) {
                if (!(empty($trabajo['titulo']))) {
                    array_push($trabajos_nuevos, $trabajo);
                }
            }
            update_post_meta($post_id, 'trabajos', $trabajos_nuevos);
        }

    }
}
 
$os_perfiles_de_usuario = new OS_Perfiles_de_Usuario();


function create_perfiles_taxonomy() {

    // Set the name of the taxonomy
    $taxonomy = 'perfil';
    // Set the post types for the taxonomy
    $object_type = 'guest-author';

    // Populate our array of names for our taxonomy
    $labels = array(
        'name'               => __('Perfil', 'os_perfiles_de_usuario'),
        'singular_name'      => __('Perfil', 'os_perfiles_de_usuario'),
        'search_items'       => __('Buscar perfiles', 'os_perfiles_de_usuario'),
        'all_items'          => __('Todos', 'os_perfiles_de_usuario'),
        'parent_item'        => __('Superior', 'os_perfiles_de_usuario'),
        'parent_item_colon'  => __('Superior:', 'os_perfiles_de_usuario'),
        'update_item'        => __('Actualizar perfil', 'os_perfiles_de_usuario'),
        'edit_item'          => __('Editar perfil', 'os_perfiles_de_usuario'),
        'add_new_item'       => __('Añadir nuevo perfil', 'os_perfiles_de_usuario'), 
        'new_item_name'      => __('Nuevo perfil', 'os_perfiles_de_usuario'),
        'menu_name'          => __('Ámbitos geográficos', 'os_perfiles_de_usuario'),
    );

    // Define arguments to be used 
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'how_in_nav_menus'  => true,
        'public'            => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'perfil')
    );

    // Call the register_taxonomy function
    register_taxonomy($taxonomy, $object_type, $args); 

    wp_insert_term(__('Miembro', 'os_perfiles_de_usuario'), 'perfil');
    wp_insert_term(__('Coordinador', 'os_perfiles_de_usuario'), 'perfil');
    wp_insert_term(__('Asesor', 'os_perfiles_de_usuario'), 'perfil');
    wp_insert_term(__('Autor', 'os_perfiles_de_usuario'), 'perfil');
    wp_insert_term(__('Ponente', 'os_perfiles_de_usuario'), 'perfil');

}
add_action('init', 'create_perfiles_taxonomy', 0);


add_action( 'init', 'add_author_rules' );
function add_author_rules() { 
    add_rewrite_rule(
        "writer/([^/]+)/?",
        "index.php?author_name=$matches[1]",
        "top");
   
    add_rewrite_rule(
  "writer/([^/]+)/page/?([0-9]{1,})/?",
  "index.php?author_name=$matches[1]&paged=$matches[2]",
  "top");
   
    add_rewrite_rule(
  "writer/([^/]+)/(feed|rdf|rss|rss2|atom)/?",
  "index.php?author_name=$matches[1]&feed=$matches[2]",
  "top");
     
    add_rewrite_rule(
  "writer/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?",
  "index.php?author_name=$matches[1]&feed=$matches[2]",
  "top");
}

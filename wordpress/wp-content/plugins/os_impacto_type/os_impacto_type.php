<?php

/*
    Plugin Name: OS Impacto Type
    Plugin URI: https://www.opensistemas.com/
    Description: Crea el tipo de contenido 'impacto'.
    Version: 1.0
    Author: Marta Oliver
    Author URI: https://www.opensistemas.com/
    License: GPLv2 or later
    Text Domain: os_impacto_type
*/


function load_text_domain_impacto() {
  load_plugin_textdomain('os_impacto_type', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'load_text_domain_impacto', 10);


function impacto_type() {
  $labels = array(
    'name'                => _x('Impactos', 'post type general name', 'os_impacto_type'),
    'singular_name'       => _x('Impacto', 'post type singular name', 'os_impacto_type'),
    'menu_name'           => __('Impactos', 'os_impacto_type'),
    'parent_item_colon'   => __('Superior:', 'os_impacto_type'),
    'all_items'           => __('Todas los impactos', 'os_impacto_type'),
    'view_item'           => __('Ver impacto', 'os_impacto_type'),
    'add_new_item'        => __('Añadir nueva impacto', 'os_impacto_type'),
    'add_new'             => __('Añadir nueva', 'os_impacto_type'),
    'edit_item'           => __('Editar impacto', 'os_impacto_type'),
    'update_item'         => __('Actualizar impacto', 'os_impacto_type'),
    'search_items'        => __('Buscar impactos', 'os_impacto_type'),
    'not_found'           => __('No se han encontrado impactos.', 'os_impacto_type'),
    'not_found_in_trash'  => __('No se han encontrado impactos en la papelera.', 'os_impacto_type'),
  );
  $args = array(
      'labels'             => $labels,
      'description'        => __( 'Descripción.', 'os_impacto_type'),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'impacto'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'menu_icon'           => 'dashicons-chart-pie',
      'supports'           => array('title'),
      'taxonomies'         => array()
  );
  register_post_type('impacto', $args );
}
add_action('init', 'impacto_type', 0);


function impacto_meta_boxes() {
  add_meta_box('impacto_tipo_y_datos', __('Tipo de visualización y datos', 'os_impacto_type'), 'meta_box_tipo', 'impacto', 'normal', 'high');
}
add_action('add_meta_boxes', 'impacto_meta_boxes');


function load_impacto_scripts() {

  // Cargar scripts
  wp_register_script('jquery_simplecolorpicker_js', get_template_directory_uri() . '/resources/js/jquery.simplecolorpicker.js', array('jquery'));
  wp_enqueue_script('jquery_simplecolorpicker_js');
  wp_register_script('os_impacto_type_js', plugins_url('js/os_impacto_type.js' , __FILE__), array('jquery', 'jquery_simplecolorpicker_js'));
  wp_enqueue_script('os_impacto_type_js');

  // Cargar styles
  wp_register_style('jquery_simplecolorpicker_css', get_template_directory_uri() . '/resources/css/jquery.simplecolorpicker.css', false, '1.0.0' );
  wp_enqueue_style('jquery_simplecolorpicker_css');

}
add_action('admin_enqueue_scripts', 'load_impacto_scripts');


// Campo para seleccionar el tipo e introducir los datos
function meta_box_tipo($post) {

  wp_nonce_field(basename(__FILE__), 'meta_box_tipo-nonce');

  $visualizacion = (get_post_meta($post->ID, 'visualizacion', true)) ? get_post_meta($post->ID, 'visualizacion', true) : "circulo";
  $color = get_post_meta($post->ID, 'color', true);
  $etiqueta = get_post_meta($post->ID, 'etiqueta', true);
  $objetivo = get_post_meta($post->ID, 'objetivo', true);
  $completado = get_post_meta($post->ID, 'completado', true);
  $titulo = get_post_meta($post->ID, 'titulo', true);
  $subtitulo = get_post_meta($post->ID, 'subtitulo', true);
  $icono = get_post_meta($post->ID, 'icono', true);

  ?>
  <p>
    <label for="visualizacion"><?php _e('Tipo de visualización', 'os_publicacion_type'); ?></label>
    <select class="widefat" name="visualizacion" id="visualizacion">
      <option value="circulo" <?php if ($visualizacion == "circulo") echo 'selected="selected"'; ?>><?php _e('Círculo', 'os_impacto_type'); ?></option>
      <option value="barra" <?php if ($visualizacion == "barra") echo 'selected="selected"'; ?>><?php _e('Barra', 'os_impacto_type'); ?></option>
      <option value="icono" <?php if ($visualizacion == "icono") echo 'selected="selected"'; ?>><?php _e('Icono', 'os_impacto_type'); ?></option>
    </select>
  </p>
  <div id="form1" name="form1" <?php if ($visualizacion == "circulo" || $visualizacion == "barra") echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
    <div class="form-group">
      <label class="col-sm-4 control-label" for="colorpicker-bootstrap3-form"><?php _e('Seleccione un color', 'os_impacto_type'); ?></label>
      <div class="col-sm-6">
        <select name="color" id="color" class="form-control">
          <option value="#5bbeff" <?php if ($color == "#5bbeff") echo 'selected="selected"'; ?>><?php _e('Azul claro', 'os_impacto_type'); ?></option>
          <option value="#f8cd51" <?php if ($color == "#f8cd51") echo 'selected="selected"'; ?>><?php _e('Amarillo', 'os_impacto_type'); ?></option>
          <option value="#14afb0" <?php if ($color == "#14afb0") echo 'selected="selected"'; ?>><?php _e('Azul verdoso', 'os_impacto_type'); ?></option>
        </select>
      </div>
    </div>
    <p>
      <label for="etiqueta"><?php _e('Etiqueta de texto', 'os_publicacion_type'); ?></label>
      <input type="text" class="widefat" id="etiqueta" name="etiqueta" value="<?php if (isset($etiqueta)) echo $etiqueta; ?>"/>
    </p>
    <p>
      <label for="objetivo"><?php _e('Valor objetivo', 'os_publicacion_type'); ?></label>
      <input type="number" class="widefat" id="objetivo" name="objetivo" value="<?php if (isset($objetivo)) echo $objetivo; ?>"/>
      <i><?php _e('El formato para este campo debe ser exclusivamente numérico. Ejemplo', 'os_publicacion_type'); ?>: 1400000</i>
    </p>
    <p>
      <label for="completado"><?php _e('Valor completado', 'os_publicacion_type'); ?></label>
      <input type="number" class="widefat" id="completado" name="completado" value="<?php if (isset($completado)) echo $completado; ?>"/>
      <i><?php _e('El formato para este campo debe ser exclusivamente numérico. Ejemplo', 'os_publicacion_type'); ?>: 2500000</i>
    </p>
  </div>
  <div id="form2" name="form2" <?php if ($visualizacion == "icono") echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>>
    <p>
      <label for="titulo"><?php _e('Título', 'os_publicacion_type'); ?></label>
      <input type="text" class="widefat" id="titulo" name="titulo" value="<?php if (isset($titulo)) echo $titulo; ?>"/>
    </p>
    <p>
      <label for="subtitulo"><?php _e('Subtítulo', 'os_publicacion_type'); ?></label>
      <input type="text" class="widefat" id="subtitulo" name="subtitulo" value="<?php if (isset($subtitulo)) echo $subtitulo; ?>"/>
    </p>
    <p>
      <label for="icono"><?php _e('Icono', 'os_publicacion_type'); ?></label>
      <input type="text" class="widefat" id="icono" name="icono" value="<?php if (isset($icono)) echo $icono; ?>"/>
    </p>
  </div>
  <?php
}


function meta_boxes_impacto_save($post_id) {

  if (isset($_POST['color'])) {
    update_post_meta($post_id, 'color', strip_tags($_POST['color']));
  }

}
add_action('save_post', "meta_boxes_impacto_save");
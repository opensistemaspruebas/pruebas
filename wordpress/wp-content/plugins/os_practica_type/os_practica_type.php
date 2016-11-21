<?php

/*
    Plugin Name: OS Practica Type
    Plugin URI: https://www.opensistemas.com/
    Description: Crea el tipo de contenido 'mejores practicas'.
    Version: 1.0
    Author: Roberto Moreno
    Author URI: https://www.opensistemas.com/
    License: GPLv2 or later
    Text Domain: os_practica_type
*/


function load_text_domain_practica() {
  load_plugin_textdomain('os_practica_type', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'load_text_domain_practica', 10);


function practica_type() {
  $labels = array(
    'name'                => _x('Práctica', 'post type general name', 'os_practica_type'),
    'singular_name'       => _x('Práctica', 'post type singular name', 'os_practica_type'),
    'menu_name'           => __('Práctica', 'os_practica_type'),
    'parent_item_colon'   => __('Superior:', 'os_practica_type'),
    'all_items'           => __('Todas las prácticas', 'os_practica_type'),
    'view_item'           => __('Ver práctica', 'os_practica_type'),
    'add_new_item'        => __('Añadir nueva práctica', 'os_practica_type'),
    'add_new'             => __('Añadir nueva', 'os_practica_type'),
    'edit_item'           => __('Editar práctica', 'os_practica_type'),
    'update_item'         => __('Actualizar práctica', 'os_practica_type'),
    'search_items'        => __('Buscar prácticas', 'os_practica_type'),
    'not_found'           => __('No se han encontrado prácticas.', 'os_practica_type'),
    'not_found_in_trash'  => __('No se han encontrado prácticas en la papelera.', 'os_practica_type'),
  );
  $args = array(
      'labels'             => $labels,
      'description'        => __('Descripción.', 'os_practica_type'),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'practica'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'menu_icon'           => 'dashicons-thumbs-up',
      'supports'           => array('title')
  );
  register_post_type('practica', $args );
}
add_action('init', 'practica_type', 0);


function register_admin_scripts_practica() {
    global $typenow, $post;
    
    if ($typenow == 'practica') {
      wp_enqueue_media();
      wp_register_script('os_practica_type-js', plugins_url('js/os_practica_type.js' , __FILE__), array('jquery'));           
      $translation_array = array(
        'choose_organization_logo' => __('Seleccionar logo', 'os_practica_type')
      );
      wp_localize_script( 'os_practica_type-js', 'object_name', $translation_array );
      wp_enqueue_script('os_practica_type-js');
    }
}
add_action('admin_enqueue_scripts', 'register_admin_scripts_practica');


function practica_meta_boxes() {  
  add_meta_box("practica_texto_descripcion" ,__("Texto descriptivo", "os_practica_type"), "meta_box_texto_descriptivo_practica", 'practica', 'advanced', 'high');
  add_meta_box("practica_imagen_cabecera" ,__("Imagen cabecera", "os_practica_type"), "meta_box_imagen_cabecera_practica", 'practica', 'normal', 'high');
  add_meta_box("practica_imagen_card" ,__("Imagen Card", "os_practica_type"), "meta_box_imagen_card_practica", 'practica', 'normal', 'high');
  add_meta_box("practica_url" ,__("URL", "os_practica_type"), "meta_box_url_practica", 'practica', 'normal', 'high');
}
add_action('add_meta_boxes', 'practica_meta_boxes');




function meta_box_texto_descriptivo_practica($post) {
  wp_nonce_field(basename(__FILE__), 'meta_box_texto_descriptivo_practica-nonce');

  $texto_destacado = get_post_meta($post->ID, 'texto-destacado', true);

  ?>

  <p>
    <textarea type="text" style="width:100%;" rows="4" id="texto-destacado" name="texto-destacado"><?php if (isset($texto_destacado)) echo $texto_destacado; ?></textarea>
  </p>

  <?php
}


function meta_box_imagen_cabecera_practica($post) {         

  wp_nonce_field(basename(__FILE__), 'meta_box_imagen_cabecera_practica-nonce');

  $imagenCabecera = get_post_meta($post->ID, 'imagenCabecera', true);
  $imagen_cabecera_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCabecera));
?>

  <p>
    <label for="imagenCabecera"><?php _e('Imagen cabecera', 'os_practica_type'); ?></label>
    <input class="widefat" id="imagenCabecera" name="imagenCabecera" type="text" value="<?php if (!empty($imagenCabecera)) echo $imagenCabecera; ?>" readonly="readonly"/>
    <img id="show_imagenCabecera" draggable="false" alt="" name="show_imagenCabecera" src="<?php if (!empty($imagen_cabecera_thumbnail)) echo esc_attr($imagen_cabecera_thumbnail); ?>" style="<?php if (empty($imagen_cabecera_thumbnail)) echo "display: none;"; ?>">
  </p>
  <p>
    <input id="upload_imagenCabecera" name="upload_imagenCabecera" type="button" value="<?php _e('Explorar/Subir', 'os_practica_type'); ?>" />
  </p>
            
<?php
       
}


        
function meta_box_imagen_card_practica($post) {         

  wp_nonce_field(basename(__FILE__), 'meta_box_imagen_card_practica-nonce');

  $imagenCard = get_post_meta($post->ID, 'imagenCard', true);
  $imagen_card_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCard));
?>

  <p>
    <label for="imagenCard"><?php _e('Imagen Card', 'os_practica_type'); ?></label>
    <input class="widefat" id="imagenCard" name="imagenCard" type="text" value="<?php if (!empty($imagenCard)) echo $imagenCard; ?>" readonly="readonly"/>
    <img id="show_imagenCard" draggable="false" alt="" name="show_imagenCard" src="<?php if (!empty($imagen_card_thumbnail)) echo esc_attr($imagen_card_thumbnail); ?>" style="<?php if (empty($imagen_card_thumbnail)) echo "display: none;"; ?>">
  </p>
  <p>
    <input id="upload_imagenCard" name="upload_imagenCard" type="button" value="<?php _e('Explorar/Subir', 'os_practica_type'); ?>" />
  </p>
            
<?php
       
}


function meta_box_url_practica($post) {
  wp_nonce_field(basename(__FILE__), 'meta_box_url_practica-nonce');

  $urlPractica = get_post_meta($post->ID, 'urlPractica', true);
  $externo10 = get_post_meta($post->ID, 'externo10', true);

  ?>

  <p>
    <input type="url" class="widefat" id="urlPractica" name="urlPractica" value="<?php if (isset($urlPractica)) echo $urlPractica; ?>" />
  </p>
  <p>
    <input class="widefat" id="externo10" name="externo10" type="checkbox" <?php checked($externo10, 'on'); ?> />
    <label for="externo10"><?php _e('Abrir enlace en una nueva ventana', 'os_practica_type'); ?></label>
  </p>

  <?php
}



function meta_boxes_save_practica($post_id) {

  if(isset($_POST['texto-destacado'])) {
    update_post_meta($post_id, 'texto-destacado', strip_tags($_POST['texto-destacado']));
  }
 
  if (isset($_POST['imagenCard'])) {
    update_post_meta($post_id, 'imagenCard', strip_tags($_POST['imagenCard']));
  }
 
  if (isset($_POST['imagenCabecera'])) {
    update_post_meta($post_id, 'imagenCabecera', strip_tags($_POST['imagenCabecera']));
  }

  if(isset($_POST['urlPractica'])) {
    update_post_meta($post_id, 'urlPractica', strip_tags($_POST['urlPractica']));
  }

  if (isset($_POST['externo10'])) {
    update_post_meta($post_id, 'externo10', strip_tags($_POST['externo10']));
  } 
  else {
    update_post_meta($post_id, 'externo10', "off");
  }
}

add_action('save_post', "meta_boxes_save_practica");

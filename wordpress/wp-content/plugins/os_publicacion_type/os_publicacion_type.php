<?php

/*
	Plugin Name: OS Publicación Type
	Plugin URI: https://www.opensistemas.com/
	Description: Crea el tipo de contenido 'publicación'.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_publicacion_type
*/


function load_text_domain_publicacion() {
  load_plugin_textdomain('os_publicacion_type', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'load_text_domain_publicacion', 10);


add_theme_support('post-thumbnails');
add_post_type_support('publicacion', 'thumbnail');  
function publicacion_type() {
  $labels = array(
    'name'                => _x('Publicaciones', 'post type general name', 'os_publicacion_type'),
    'singular_name'       => _x('Publicación', 'post type singular name', 'os_publicacion_type'),
    'menu_name'           => __('Publicaciones', 'os_publicacion_type'),
    'parent_item_colon'   => __('Superior:', 'os_publicacion_type'),
    'all_items'           => __('Todas las publicaciones', 'os_publicacion_type'),
    'view_item'           => __('Ver publicación', 'os_publicacion_type'),
    'add_new_item'        => __('Añadir nueva publicación', 'os_publicacion_type'),
    'add_new'             => __('Añadir nueva', 'os_publicacion_type'),
    'edit_item'           => __('Editar publicación', 'os_publicacion_type'),
    'update_item'         => __('Actualizar publicación', 'os_publicacion_type'),
    'search_items'        => __('Buscar publicaciones', 'os_publicacion_type'),
    'not_found'           => __('No se han encontrado publicaciones.', 'os_publicacion_type'),
    'not_found_in_trash'  => __('No se han encontrado publicaciones en la papelera.', 'os_publicacion_type'),
  );
  $args = array(
      'labels'             => $labels,
      'description'        => __( 'Descripción.', 'os_publicacion_type'),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'publicacion'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'menu_icon'          => 'dashicons-welcome-write-blog',
      'supports'           => array('title', 'author', 'thumbnail', 'excerpt'),
      'taxonomies'         => array('category', 'post_tag', 'ambito_geografico')
  );
  register_post_type('publicacion', $args );
}
add_action('init', 'publicacion_type', 0);


function register_admin_scripts() {
    global $typenow, $post;
    
    if ($typenow == $post->post_type) {
      wp_enqueue_media();
      wp_register_script('os_publicacion_type-js', plugins_url('js/os_publicacion_type_min.js' , __FILE__), array('jquery'));           
      $translation_array = array(
        'choose_source_logo' => __('Seleccionar logo', 'os_publicacion_type'),
        'choose_source_pdf' => __('Seleccionar documento', 'os_publicacion_type')
      );
      wp_localize_script( 'os_publicacion_type-js', 'object_name', $translation_array );
      wp_enqueue_script('os_publicacion_type-js');
    }
}
add_action('admin_enqueue_scripts', 'register_admin_scripts');


function publicacion_meta_boxes() {
  add_meta_box('publicacion_pdf', __('Informe en PDF', 'os_publicacion_type'), 'meta_box_publicacion_pdf', 'publicacion', 'normal', 'low');
  add_meta_box('publicacion_source', __('Fuente de la publicación', 'os_publicacion_type'), 'meta_box_publicacion_source', 'publicacion', 'normal', 'low');
}
add_action('add_meta_boxes', 'publicacion_meta_boxes');


function meta_box_publicacion_pdf() {
  
  global $post;
  
  wp_nonce_field(basename(__FILE__), 'meta_box_publicacion_pdf-nonce');
  
  $pdf = get_post_meta($post->ID, 'pdf', true);
  
  ?>
  <p>
    <label for="pdf"><?php _e('Archivo PDF', 'os_publicacion_type'); ?></label>
    <input class="widefat" id="pdf" name="pdf" type="text" value="<?php if (isset($pdf)) echo $pdf; ?>" readonly="readonly"/>
  </p>
  <p>
    <input id="upload_pdf" name="upload_pdf" type="button" value="<?php _e('Explorar/Subir', 'os_publicacion_type'); ?>" />
  </p>
  <?php
}


function meta_box_publicacion_source() {
  
  global $post;
  
  wp_nonce_field(basename(__FILE__), 'meta_box_publicacion_source-nonce');
  
  $source_name = get_post_meta($post->ID, 'source_name', true);
  $source_url = get_post_meta($post->ID, 'source_url', true);
  $logo = get_post_meta($post->ID, 'source_logo', true);
  $publication_date = get_post_meta($post->ID, 'publication_date', true);
  $type = get_post_meta($post->ID, 'type', true);
  $geographical_area = get_post_meta($post->ID, 'geographical_area', true);
  $target_audiences = get_post_meta($post->ID, 'target_audiences', true);
  $number_of_pages = get_post_meta($post->ID, 'number_of_pages', true);
  $jel_code = get_post_meta($post->ID, 'jel_code', true);
  $edition = get_post_meta($post->ID, 'edition', true);
  $editorial = get_post_meta($post->ID, 'editorial', true);
  ?>
  
  <p>
    <label for="source_name"><?php _e('Nombre de la fuente', 'os_publicacion_type'); ?></label>
    <input type="text" name="source_name" value="<?php echo $source_name; ?>" class="widefat" />
  </p>
  <p>
    <label for="source_url"><?php _e('URL de la fuente', 'os_publicacion_type'); ?></label>
    <input type="link" name="source_url" value="<?php echo $source_url; ?>" class="widefat" />
  </p>
  <p>
    <label for="source_logo"><?php _e('Logo de la fuente', 'os_publicacion_type'); ?></label>
    <input class="widefat" id="source_logo" name="source_logo" type="text" value="<?php if (!empty($logo)) echo $logo; ?>" readonly="readonly"/>
    <img id="show_logo" draggable="false" alt="" name="show_logo" width="100%" src="<?php if (!empty($logo)) echo esc_attr($logo); ?>" style="<?php if (empty($logo)) echo "display: none;"; ?>">
  </p>
  <p>
    <input id="upload_logo" name="upload_logo" type="button" value="<?php _e('Explorar/Subir', 'os_publicacion_type'); ?>" />
  </p>
  <p>
    <label for="publication_date"><?php _e('Fecha de publicación', 'os_publicacion_type'); ?></label>
    <input type="date" name="publication_date" value="<?php echo $publication_date; ?>" class="widefat" />
  </p>
  <p>
    <label for="type"><?php _e('Tipo de publicación', 'os_publicacion_type'); ?></label>
    <input type="text" name="type" value="<?php echo $type; ?>" class="widefat" />
  </p>
  <p>
    <label for="geographical_area"><?php _e('Ámbito geográfico', 'os_publicacion_type'); ?></label>
    <select name="geographical_area" class="widefat">
      <?php  
        $countries = get_terms('ambito_geografico', array('hide_empty' => false));
        foreach ($countries as $country) {
          $selected = ($country->term_id == $geographical_area) ? 'selected="selected"' : '';
          ?><option <?php echo $selected; ?> value="<?php echo $country->term_id; ?>"><?php echo $country->name; ?></option><?php
        }
      ?>
    </select>
  </p>
  <p>
    <label for="target_audiences"><?php _e('Público objetivo', 'os_publicacion_type'); ?></label>
    <input type="text" name="target_audiences" value="<?php echo $target_audiences; ?>" class="widefat" />
  </p>
  <p>
    <label for="number_of_pages"><?php _e('Número de páginas', 'os_publicacion_type'); ?></label>
    <input type="number" name="number_of_pages" value="<?php echo $number_of_pages; ?>" class="widefat" />
  </p>
  <p>
    <label for="jel_code"><?php _e('Código JEL', 'os_publicacion_type'); ?></label>
    <input type="text" name="jel_code" value="<?php echo $jel_code; ?>" class="widefat" />
  </p>
  <p>
    <label for="edition"><?php _e('Edición', 'os_publicacion_type'); ?></label>
    <input type="text" name="edition" value="<?php echo $edition; ?>" class="widefat" />
  </p>
  <p>
    <label for="editorial"><?php _e('Editorial', 'os_publicacion_type'); ?></label>
    <input type="text" name="editorial" value="<?php echo $editorial; ?>" class="widefat" />
  </p>
  <?php
}


function meta_boxes_save($post_id) {
  if (isset($_POST['source_name'])) {
    update_post_meta($post_id, 'source_name', strip_tags($_POST['source_name']));
  }
  if (isset($_POST['source_url'])) {
   update_post_meta($post_id, 'source_url', strip_tags($_POST['source_url']));
  }
  if (isset($_POST['source_logo'])) {
   update_post_meta($post_id, 'source_logo', strip_tags($_POST['source_logo']));
  }
  if (isset($_POST['publication_date'])) {
    update_post_meta($post_id, 'publication_date', strip_tags($_POST['publication_date']));
  }
  if (isset($_POST['type'])) {
    update_post_meta($post_id, 'type', strip_tags($_POST['type']));
  }
  if (isset($_POST['geographical_area'])) {
   update_post_meta($post_id, 'geographical_area', strip_tags($_POST['geographical_area']));
  }
  if (isset($_POST['target_audiences'])) {
    update_post_meta($post_id, 'target_audiences', strip_tags($_POST['target_audiences']));
  }
  if (isset($_POST['number_of_pages'])) {
   update_post_meta($post_id, 'number_of_pages', strip_tags($_POST['number_of_pages']));
  }
  if (isset($_POST['jel_code'])) {
    update_post_meta($post_id, 'jel_code', strip_tags($_POST['jel_code']));
  }
  if (isset($_POST['edition'])) {
   update_post_meta($post_id, 'edition', strip_tags($_POST['edition']));
  }
  if (isset($_POST['editorial'])) {
    update_post_meta($post_id, 'editorial', strip_tags($_POST['editorial']));
  }
  if (isset($_POST['pdf'])) {
    update_post_meta($post_id, 'pdf', strip_tags($_POST['pdf']));
  }
}
add_action('save_post', "meta_boxes_save");
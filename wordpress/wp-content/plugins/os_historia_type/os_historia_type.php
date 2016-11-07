<?php

/*
    Plugin Name: OS Historia Type
    Plugin URI: https://www.opensistemas.com/
    Description: Crea el tipo de contenido 'historia'.
    Version: 1.0
    Author: Marta Oliver
    Author URI: https://www.opensistemas.com/
    License: GPLv2 or later
    Text Domain: os_historia_type
*/


function load_text_domain_story() {
  load_plugin_textdomain('os_historia_type', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'load_text_domain_story', 10);


function historia_type() {
  $labels = array(
    'name'                => _x('Historias', 'post type general name', 'os_historia_type'),
    'singular_name'       => _x('Historia', 'post type singular name', 'os_historia_type'),
    'menu_name'           => __('Historias', 'os_historia_type'),
    'parent_item_colon'   => __('Superior:', 'os_historia_type'),
    'all_items'           => __('Todas las historias', 'os_historia_type'),
    'view_item'           => __('Ver historia', 'os_historia_type'),
    'add_new_item'        => __('Añadir nueva historia', 'os_historia_type'),
    'add_new'             => __('Añadir nueva', 'os_historia_type'),
    'edit_item'           => __('Editar historia', 'os_historia_type'),
    'update_item'         => __('Actualizar historia', 'os_historia_type'),
    'search_items'        => __('Buscar historias', 'os_historia_type'),
    'not_found'           => __('No se han encontrado historias.', 'os_historia_type'),
    'not_found_in_trash'  => __('No se han encontrado historias en la papelera.', 'os_historia_type'),
  );
  $args = array(
      'labels'             => $labels,
      'description'        => __( 'Descripción.', 'os_historia_type'),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'historia'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'menu_icon'           => 'dashicons-book',
      'supports'           => array('title', 'author', 'editor'),
      'taxonomies'         => array('category', 'ambito_geografico')
  );
  register_post_type('historia', $args );
}
add_action('init', 'historia_type', 0);


function register_admin_scripts_historia() {
    global $typenow, $post;
    
    if ($typenow == 'historia') {
      wp_enqueue_media();
      wp_register_script('os_historia_type-js', plugins_url('js/os_historia_type.js' , __FILE__), array('jquery'));           
      $translation_array = array(
        'choose_organization_logo' => __('Seleccionar logo', 'os_historia_type')
      );
      wp_localize_script( 'os_historia_type-js', 'object_name', $translation_array );
      wp_enqueue_script('os_historia_type-js');
    }
}
add_action('admin_enqueue_scripts', 'register_admin_scripts_historia');



function historia_meta_boxes() {
  add_meta_box("historia_subtitulo" ,__("Subtítulo", "os_historia_type"), "meta_box_subtitulo_historia", 'historia', 'advanced', 'high');
  add_meta_box("historia_texto_destacado" ,__("Texto destacado", "os_historia_type"), "meta_box_texto_destacado_historia", 'historia', 'advanced', 'high');
  add_meta_box("historia_destacada" ,__("Historia destacada", "os_historia_type"), "meta_box_destacada_historia", 'historia', 'side', 'high');
  add_meta_box("historia_imagen_card" ,__("Imagen Card", "os_historia_type"), "meta_box_imagen_card_historia", 'historia', 'normal', 'high');
  //add_meta_box("historia_imagen_cabecera" ,__("Imagen cabecera", "os_historia_type"), "meta_box_imagen_cabecera_historia", 'historia', 'normal', 'high');
  add_meta_box("historia_video_intro" ,__("Video de introducción cabecera", "os_historia_type"), "meta_box_videoIntro_historia", 'historia', 'normal', 'high');
  add_meta_box("historia_video" ,__("Video final cabecera", "os_historia_type"), "meta_box_video_historia", 'historia', 'normal', 'high');
}
add_action('add_meta_boxes', 'historia_meta_boxes');


function meta_box_destacada_historia($post) {

  wp_nonce_field(basename(__FILE__), 'meta_box_destacada_historia-nonce');

  $destacada = get_post_meta($post->ID, 'destacada', true);

  ?>

  <p>
    <input class="widefat" id="destacada" name="destacada" type="checkbox" <?php checked($destacada, 'on'); ?> />
    <label for="destacada"><?php _e('Marcar la historia como destacada', 'os_historia_type'); ?></label>
  </p>
            
<?php
       
}

function meta_box_subtitulo_historia($post) {
  wp_nonce_field(basename(__FILE__), 'meta_box_subtitulo_historia-nonce');

  $subtitulo = get_post_meta($post->ID, 'subtitulo', true);

  ?>

  <p>
  <input class="widefat" id="subtitulo" name="subtitulo" value="<?php if (isset($subtitulo)) echo $subtitulo; ?>" />
  </p>

  <?php
}

function meta_box_texto_destacado_historia($post) {
  wp_nonce_field(basename(__FILE__), 'meta_box_texto_destacado_historia-nonce');

  $texto_destacado = get_post_meta($post->ID, 'texto-destacado', true);

  ?>

  <p>
  <textarea style="width:100%;" rows="3" id="texto-destacado" name="texto-destacado"><?php if (isset($texto_destacado)) echo $texto_destacado; ?></textarea>
  </p>

  <?php
}

/*function meta_box_imagen_cabecera_historia($post) {         

  wp_nonce_field(basename(__FILE__), 'meta_box_imagen_cabecera_historia-nonce');

  $imagenCabecera = get_post_meta($post->ID, 'imagenCabecera', true);
  $imagen_cabecera_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCabecera));
?>

  <p>
    <label for="imagenCabecera"><?php _e('Imagen cabecera', 'os_historia_type'); ?></label>
    <input class="widefat" id="imagenCabecera" name="imagenCabecera" type="text" value="<?php if (!empty($imagenCabecera)) echo $imagenCabecera; ?>" readonly="readonly"/>
    <img id="show_imagenCabecera" draggable="false" alt="" name="show_imagenCabecera" src="<?php if (!empty($imagen_cabecera_thumbnail)) echo esc_attr($imagen_cabecera_thumbnail); ?>" style="<?php if (empty($imagen_cabecera_thumbnail)) echo "display: none;"; ?>">
  </p>
  <p>
    <input id="upload_imagenCabecera" name="upload_imagenCabecera" type="button" value="<?php _e('Explorar/Subir', 'os_historia_type'); ?>" />
    <i><?php _e('Si el campo "Video cabecera" está relleno, se mostrará este en vez de "Imagen cabecera"','os_historia_type'); ?></i>
  </p>
            
<?php
       
}*/


        
function meta_box_imagen_card_historia($post) {         

  wp_nonce_field(basename(__FILE__), 'meta_box_imagen_card_historia-nonce');

  $imagenCard = get_post_meta($post->ID, 'imagenCard', true);
  $imagen_card_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCard));
?>

  <p>
    <label for="imagenCard"><?php _e('Imagen Card', 'os_historia_type'); ?></label>
    <input class="widefat" id="imagenCard" name="imagenCard" type="text" value="<?php if (!empty($imagenCard)) echo $imagenCard; ?>" readonly="readonly"/>
    <img id="show_imagenCard" draggable="false" alt="" name="show_imagenCard" src="<?php if (!empty($imagen_card_thumbnail)) echo esc_attr($imagen_card_thumbnail); ?>" style="<?php if (empty($imagen_card_thumbnail)) echo "display: none;"; ?>">
  </p>
  <p>
    <input id="upload_imagenCard" name="upload_imagenCard" type="button" value="<?php _e('Explorar/Subir', 'os_historia_type'); ?>" />
  </p>
            
<?php
       
}

function meta_box_videoIntro_historia($post) {
  wp_nonce_field( basename( __FILE__ ), 'videoIntro_historia-nonce' );

  $videoIntro_url = get_post_meta($post->ID,'videoIntro-url',true);

  ?>

    <p class="videoIntro-wordpress">
      <label for="videoIntro-url"><?php _e('Video introducción', 'os_historia_type'); ?></label>
      <input class="widefat" id="videoIntro-url" name="videoIntro-url" type="text" value="<?php if (isset($videoIntro_url)) echo $videoIntro_url; ?>"/>
      <i><?php _e('Es el video que se mostrará al cargar la página en estado autoplay, debe estar subido a wordpress','os_historia_type'); ?></i>
    </p>    
    <p class="videoIntro-wordpress">
      <input id="upload_videoIntroHistoria" name="upload_videoIntroHistoria" type="button" value="<?php _e('Explorar/Subir', 'os_historia_type'); ?>" />
    </p>

  <?php 
}

function meta_box_video_historia($post) {
  wp_nonce_field( basename( __FILE__ ), 'video_historia-nonce' );

  $video_type = get_post_meta($post->ID,'video-type',true); 
  if($video_type == '') {
    $video_type = 'youtube';
  }
  $wp_video_url = get_post_meta($post->ID,'wp-video-url',true);
  $yt_video_url = get_post_meta($post->ID,'yt-video-url',true);

  ?>

    <p>
      <label for="video-type"><?php _e('Fuente: ','os_historia_type'); ?></label>
      <input type="radio" name="video-type" id="video-type-yt" value="youtube" <?php if ( !empty ( $video_type ) ) { checked( $video_type, 'youtube' );} ?>>
      <label for="video-type-yt"><?php _e( 'Youtube', 'os_historia_type' )?></label>
      <input type="radio" name="video-type" id="video-type-wp" value="wordpress" <?php if ( !empty ( $video_type ) ) { checked( $video_type, 'wordpress' ); } ?>>
      <label for="video-type-wp"><?php _e( 'Wordpress', 'os_historia_type' )?></label>
    </p>

    <p class="video-youtube" <?php if($video_type != 'youtube') { echo 'style="display: none;"'; } ?>>
      <label for="yt-video-url"><?php _e('Enlace de Youtube', 'os_historia_type'); ?></label>
      <input class="widefat" id="yt-video-url" name="yt-video-url" type="text" value="<?php if (isset($yt_video_url)) echo $yt_video_url; ?>"/>
      <i><?php _e('Este video aparecerá en una ventana modal al hacer click sobre el icono Play. ','os_historia_type'); ?></i>
      <i><?php _e('Se debe coger la URL del campo src (sin las comillas) que aparece al hacer click en "Insertar", en la página del video de Youtube que se quiera mostrar','os_historia_type'); ?></i>
    </p>

    <p class="video-wordpress" <?php if($video_type != 'wordpress') { echo 'style="display: none;"'; } ?>>
      <label for="wp-video-url"><?php _e('URL video', 'os_historia_type'); ?></label>
      <input class="widefat" id="wp-video-url" name="wp-video-url" type="text" value="<?php if (isset($wp_video_url)) echo $wp_video_url; ?>"/>
      <i><?php _e('Este video aparecerá en una ventana modal al hacer click sobre el icono Play','os_historia_type'); ?></i>
    </p>    
    <p class="video-wordpress" <?php if($video_type != 'wordpress') { echo 'style="display: none;"'; } ?>>
      <input id="upload_videoHistoria" name="upload_videoHistoria" type="button" value="<?php _e('Explorar/Subir', 'os_historia_type'); ?>" />
    </p>

  <?php 
}

/* Utilizo esta función para mover los metaboxes con ubicación "advanced" encima del editor de Wordpress */
function mover_advanced_arriba() {

    # Get the globals:
    global $post, $wp_meta_boxes;
    # Output the "advanced" meta boxes:
    do_meta_boxes(get_current_screen(), 'advanced', $post);
    # Remove the initial "advanced" meta boxes:
    unset($wp_meta_boxes[get_post_type($post)]['advanced']);

}

add_action('edit_form_after_title', 'mover_advanced_arriba');



function meta_boxes_save_historia($post_id) {

  if(user_can_save($post_id, 'meta_box_subtitulo_historia-nonce')) {
    if(isset($_POST['subtitulo'])) {
      update_post_meta($post_id, 'subtitulo', strip_tags($_POST['subtitulo']));
    }
  }

  if(user_can_save($post_id, 'meta_box_texto_destacado_historia-nonce')) {
    if(isset($_POST['texto-destacado'])) {
      update_post_meta($post_id, 'texto-destacado', strip_tags($_POST['texto-destacado']));
    }
  }

  if(user_can_save($post_id, 'meta_box_imagen_card_historia-nonce')) {
    if (isset($_POST['imagenCard'])) {
      update_post_meta($post_id, 'imagenCard', strip_tags($_POST['imagenCard']));
    }
  }
  
  /*if(user_can_save($post_id, 'meta_box_imagen_cabecera_historia-nonce')) {
    if (isset($_POST['imagenCabecera'])) {
     update_post_meta($post_id, 'imagenCabecera', strip_tags($_POST['imagenCabecera']));
    }
  }*/

  if(user_can_save($post_id, 'meta_box_destacada_historia-nonce')) {
    if (isset($_POST['destacada'])) {
      update_post_meta($post_id, 'destacada', strip_tags($_POST['destacada']));
    } else {
      update_post_meta($post_id, 'destacada', "off");
    }
  }

  if(user_can_save($post_id, 'videoIntro_historia-nonce')) {
    if(isset($_POST['videoIntro-url'])) {
      update_post_meta($post_id, 'videoIntro-url', strip_tags($_POST['videoIntro-url']));
    }
  }

  if(user_can_save($post_id, 'video_historia-nonce')) {
    if (isset($_POST['video-type'])) {
      update_post_meta($post_id, 'video-type', strip_tags($_POST['video-type']));
      if($_POST['video-type'] == 'youtube') {
        if(isset($_POST['yt-video-url'])) {
          update_post_meta($post_id, 'yt-video-url', strip_tags($_POST['yt-video-url']));
        }
      } else if($_POST['video-type'] == 'wordpress') {
        if(isset($_POST['wp-video-url'])) {
          update_post_meta($post_id, 'wp-video-url', strip_tags($_POST['wp-video-url']));
        }
      }
    }
  }
}
add_action('save_post', "meta_boxes_save_historia");

//////////////// FUNCIONES PRIVADAS ////////////////////

/*
* Comprueba si el usuario puede salvar los cambios
*/
function user_can_save( $post_id, $nonce ) {

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
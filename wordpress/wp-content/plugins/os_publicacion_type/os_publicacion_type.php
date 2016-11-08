<?php

/*
	Plugin Name: OS Publicación Type
	Plugin URI: https://www.opensistemas.com/
	Description: Crea el tipo de contenido 'publicación'.
	Version: 1.0
	Author: Marta Oliver / Roberto Moreno
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_publicacion_type
*/


function load_text_domain_publicacion() {
  load_plugin_textdomain('os_publicacion_type', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'load_text_domain_publicacion', 10);


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
      'description'        => __('Descripción.', 'os_publicacion_type'),
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
      'supports'           => array('title', 'author'),
      'taxonomies'         => array('category', 'ambito_geografico')
  );
  register_post_type('publicacion', $args );
}
add_action('init', 'publicacion_type', 0);


function register_admin_scripts() {
    global $typenow, $post;
    
    if ($typenow == "publicacion") {
      wp_enqueue_media();
      wp_register_script('os_publicacion_type-js', plugins_url('js/os_publicacion_type.js' , __FILE__), array('jquery'));           
      $translation_array = array(
        'choose_organization_logo' => __('Seleccionar logo', 'os_publicacion_type')
      );
      wp_localize_script( 'os_publicacion_type-js', 'object_name', $translation_array );
      wp_enqueue_script('os_publicacion_type-js');
    }
}
add_action('admin_enqueue_scripts', 'register_admin_scripts');


function register_admin_styles() {
    global $typenow;
    if ($typenow == "publicacion") {
        wp_enqueue_style('os-publicacion-type-css', plugin_dir_url(__FILE__) . 'css/os_publicacion_type.css');           
    }
}
add_action('admin_print_styles', 'register_admin_styles');


function publicacion_meta_boxes() {
  add_meta_box("publicacion_destacada" ,__("Publicación destacada", "os_publicacion_type"), "meta_box_destacada", 'publicacion', 'side', 'high');
  add_meta_box("publicacion_imagen_card" ,__("Imagen Card", "os_publicacion_type"), "meta_box_imagen_card", 'publicacion', 'normal', 'high');
  add_meta_box("publicacion_imagen_cabecera" ,__("Imagen de la cabecera", "os_publicacion_type"), "meta_box_imagen_cabecera", 'publicacion', 'normal', 'high');
  add_meta_box('publicacion_abstract_destacado',  __('Texto destacado del abstract', 'os_publicacion_type'), 'meta_box_abstract_destacado', 'publicacion', 'normal', 'high');
  add_meta_box('publicacion_abstract_contenido',  __('Texto normal del abstract', 'os_publicacion_type'), 'meta_box_abstract_contenido', 'publicacion', 'normal', 'high');
  add_meta_box('publicacion_pdf', __('Informe en PDF', 'os_publicacion_type'), 'meta_box_publicacion_pdf', 'publicacion', 'normal', 'high');
  add_meta_box('publicacion_source_link', __('Link a la fuente', 'os_publicacion_type'), 'meta_box_source_link', 'publicacion', 'normal', 'high');
  add_meta_box('publicacion_info', __('Información adicional', 'os_publicacion_type'), 'meta_box_publicacion_info', 'publicacion', 'normal', 'high');
  add_meta_box("publicacion_video_intro" ,__("Video de introducción", "os_publicacion_type"), "meta_box_videoIntro_publicacion", 'publicacion', 'normal', 'high');
  add_meta_box("publicacion_video" ,__("Video completo", "os_publicacion_type"), "meta_box_video_publicacion", 'publicacion', 'normal', 'high');
  add_meta_box("publicacion_puntos_clave" ,__("Puntos clave", "os_publicacion_type"), "meta_box_puntos_clave_publicacion", 'publicacion', 'normal', 'high');
}
add_action('add_meta_boxes', 'publicacion_meta_boxes');


function meta_box_destacada($post) {

  wp_nonce_field(basename(__FILE__), 'meta_box_destacada-nonce');

  $destacada = get_post_meta($post->ID, 'destacada', true);

  ?>

  <p>
    <input class="widefat" id="destacada" name="destacada" type="checkbox" <?php checked($destacada, 'on'); ?> />
    <label for="destacada"><?php _e('Marcar la publicación como destacada', 'os_publicacion_type'); ?></label>
  </p>
            
<?php
       
}


function meta_box_imagen_cabecera($post) {         

  wp_nonce_field(basename(__FILE__), 'meta_box_imagen_cabecera-nonce');

  $imagenCabecera = get_post_meta($post->ID, 'imagenCabecera', true);
  $imagen_cabecera_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCabecera));
?>

  <p>
    <label for="imagenCabecera"><?php _e('Imagen de la cabecera', 'os_publicacion_type'); ?></label>
    <input class="widefat" id="imagenCabecera" name="imagenCabecera" type="text" value="<?php if (!empty($imagenCabecera)) echo $imagenCabecera; ?>" readonly="readonly"/>
    <img id="show_imagenCabecera" draggable="false" alt="" name="show_imagenCabecera" src="<?php if (!empty($imagen_cabecera_thumbnail)) echo esc_attr($imagen_cabecera_thumbnail); ?>" style="<?php if (empty($imagen_cabecera_thumbnail)) echo "display: none;"; ?>">
  </p>
  <p>
    <input id="upload_imagenCabecera" name="upload_imagenCabecera" type="button" value="<?php _e('Explorar/Subir', 'os_publicacion_type'); ?>" />
  </p>
            
<?php
       
}


        
function meta_box_imagen_card($post) {         

  wp_nonce_field(basename(__FILE__), 'meta_box_imagen_card-nonce');

  $imagenCard = get_post_meta($post->ID, 'imagenCard', true);
  $imagen_card_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCard));
?>

  <p>
    <label for="imagenCard"><?php _e('Imagen Card', 'os_publicacion_type'); ?></label>
    <input class="widefat" id="imagenCard" name="imagenCard" type="text" value="<?php if (!empty($imagenCard)) echo $imagenCard; ?>" readonly="readonly"/>
    <img id="show_imagenCard" draggable="false" alt="" name="show_imagenCard" src="<?php if (!empty($imagen_card_thumbnail)) echo esc_attr($imagen_card_thumbnail); ?>" style="<?php if (empty($imagen_card_thumbnail)) echo "display: none;"; ?>">
  </p>
  <p>
    <input id="upload_imagenCard" name="upload_imagenCard" type="button" value="<?php _e('Explorar/Subir', 'os_publicacion_type'); ?>" />
  </p>
            
<?php
       
}

function meta_box_videoIntro_publicacion($post) {
  wp_nonce_field( basename( __FILE__ ), 'videoIntro_publicacion-nonce' );

  $videoIntro_url = get_post_meta($post->ID,'videoIntro-url',true);

  ?>

    <p class="videoIntro-wordpress">
      <label for="videoIntro-url"><?php _e('Video presentación', 'os_publicacion_type'); ?></label>
      <input class="widefat" id="videoIntro-url" name="videoIntro-url" type="text" value="<?php if (isset($videoIntro_url)) echo $videoIntro_url; ?>"/>
      <i><?php _e('Es el video que se mostrará al cargar la página en estado autoplay, debe estar subido a wordpress','os_publicacion_type'); ?></i>
    </p>    
    <p class="videoIntro-wordpress">
      <input id="upload_videoIntroPublicacion" name="upload_videoIntroPublicacion" type="button" value="<?php _e('Explorar/Subir', 'os_publicacion_type'); ?>" />
    </p>

  <?php 
}

function meta_box_video_publicacion($post) {
  wp_nonce_field( basename( __FILE__ ), 'video_publicacion-nonce' );

  $video_type = get_post_meta($post->ID,'video-type',true); 
  if($video_type == '') {
    $video_type = 'youtube';
  }
  $wp_video_url = get_post_meta($post->ID,'wp-video-url',true);
  $yt_video_url = get_post_meta($post->ID,'yt-video-url',true);

  ?>

    <p>
      <label for="video-type"><?php _e('Fuente: ','os_publicacion_type'); ?></label>
      <input type="radio" name="video-type" id="video-type-yt" value="youtube" <?php if ( !empty ( $video_type ) ) { checked( $video_type, 'youtube' );} ?>>
      <label for="video-type-yt"><?php _e( 'Youtube', 'os_publicacion_type' )?></label>
      <input type="radio" name="video-type" id="video-type-wp" value="wordpress" <?php if ( !empty ( $video_type ) ) { checked( $video_type, 'wordpress' ); } ?>>
      <label for="video-type-wp"><?php _e( 'Wordpress', 'os_publicacion_type' )?></label>
    </p>

    <p class="video-youtube" <?php if($video_type != 'youtube') { echo 'style="display: none;"'; } ?>>
      <label for="yt-video-url"><?php _e('Enlace de Youtube', 'os_publicacion_type'); ?></label>
      <input class="widefat" id="yt-video-url" name="yt-video-url" type="text" value="<?php if (isset($yt_video_url)) echo $yt_video_url; ?>"/>
      <i><?php _e('Este video aparecerá en una ventana modal al hacer click sobre el icono Play. ','os_publicacion_type'); ?></i>
      <i><?php _e('Se debe coger la URL del campo src (sin las comillas) que aparece al hacer click en "Insertar", en la página del video de Youtube que se quiera mostrar','os_publicacion_type'); ?></i>
    </p>

    <p class="video-wordpress" <?php if($video_type != 'wordpress') { echo 'style="display: none;"'; } ?>>
      <label for="wp-video-url"><?php _e('URL video', 'os_publicacion_type'); ?></label>
      <input class="widefat" id="wp-video-url" name="wp-video-url" type="text" value="<?php if (isset($wp_video_url)) echo $wp_video_url; ?>"/>
      <i><?php _e('Este video aparecerá en una ventana modal al hacer click sobre el icono Play','os_publicacion_type'); ?></i>
    </p>    
    <p class="video-wordpress" <?php if($video_type != 'wordpress') { echo 'style="display: none;"'; } ?>>
      <input id="upload_videoPublicacion" name="upload_videoPublicacion" type="button" value="<?php _e('Explorar/Subir', 'os_publicacion_type'); ?>" />
    </p>

  <?php 
}


function meta_box_puntos_clave_publicacion($post){

  wp_nonce_field(basename(__FILE__), 'meta_box_evento_descripcion-nonce');

  $publicacion_puntosClave = get_post_meta($post->ID, 'publicacion_puntosClave', true);

  ?>

 
  <input type="text" id="publicacion_puntosClave[0]" name="publicacion_puntosClave[0]" class="widefat ptoClave" placeholder="<?php _e('1º Punto clave', 'os_publicacion_type'); ?>" value="<?php echo $publicacion_puntosClave[0]; ?>">
  <input type="text" id="publicacion_puntosClave[1]" name="publicacion_puntosClave[1]" class="widefat ptoClave" placeholder="<?php _e('2º Punto clave', 'os_publicacion_type'); ?>" value="<?php echo $publicacion_puntosClave[1]; ?>">
  <input type="text" id="publicacion_puntosClave[2]" name="publicacion_puntosClave[2]" class="widefat" placeholder="<?php _e('3º Punto clave', 'os_publicacion_type'); ?>" value="<?php echo $publicacion_puntosClave[2]; ?>">

   <p><?php _e('Estos son los puntos clave de la publicación.', 'os_publicacion_type'); ?></p>

  <?php
}


function meta_box_abstract_destacado($post) {

  wp_nonce_field(basename(__FILE__), 'meta_box_publicacion_abstract_destacado-nonce');

  $abstract_destacado = get_post_meta($post->ID, 'abstract_destacado', true);

  ?>
  <p>
      <textarea rows="4" class="widefat" name="abstract_destacado" id="abstract_destacado"><?php echo $abstract_destacado; ?></textarea>
  </p>
  <?php   
}


function meta_box_abstract_contenido($post) {

    wp_nonce_field(basename(__FILE__), 'meta_box_abstract_contenido-nonce');

    $abstract_contenido = get_post_meta($post->ID, 'abstract_contenido', true);

    ?>
    <p>
        <textarea rows="4" class="widefat" name="abstract_contenido" id="abstract_contenido"><?php echo $abstract_contenido; ?></textarea>
    </p>
    <?php   
}


function meta_box_publicacion_pdf($post) {
  
  wp_nonce_field(basename(__FILE__), 'meta_box_publicacion_pdf-nonce');
  
  $pdf = get_post_meta($post->ID, 'pdf', true);
  $pdfInterno = get_post_meta($post->ID, 'pdfInterno', true);
  
  ?>
  <p>
    <label for="pdf"><?php _e('URL externa del archivo PDF', 'os_publicacion_type'); ?></label>
    <input type="url" class="widefat" id="pdf" name="pdf" value="<?php if (isset($pdf)) echo $pdf; ?>"/>
  </p>
  <p>
    <label for="pdfInterno"><?php _e('Cargador de archivo PDF', 'os_publicacion_type'); ?></label>
    <input type="url" class="widefat" id="pdfInterno" name="pdfInterno" value="<?php if (isset($pdfInterno)) echo $pdfInterno; ?>"/>
  </p>
  <p>
    <input id="upload_pdfInterno" name="upload_pdfInterno" type="button" value="<?php _e('Explorar/Subir', 'os_publicacion_type'); ?>" />
  </p>
  <?php
}


function meta_box_source_link($post) {
  
  wp_nonce_field(basename(__FILE__), 'meta_box_source_link-nonce');
  
  $source_url = get_post_meta($post->ID, 'source_url', true);
  $name_url = get_post_meta($post->ID, 'name_url', true);
  
  ?>
   <p>
    <label for="name_url"><?php _e('Nombre de la fuente del informe', 'os_publicacion_type'); ?></label>
    <input class="widefat" id="name_url" name="name_url" type="text" value="<?php if (isset($name_url)) echo $name_url; ?>"/>
  </p>
  <p>
    <label for="source_url"><?php _e('URL de la fuente del informe', 'os_publicacion_type'); ?></label>
    <input class="widefat" id="source_url" name="source_url" type="url" value="<?php if (isset($source_url)) echo $source_url; ?>"/>
  </p>
  <?php
}



function meta_box_publicacion_info($post) {
  
  wp_nonce_field(basename(__FILE__), 'meta_box_publicacion_info-nonce');
  
  $publication_date = get_post_meta($post->ID, 'publication_date', true);
  $type = get_post_meta($post->ID, 'type', true);  
  $target_audiences = get_post_meta($post->ID, 'target_audiences', true);
  $number_of_pages = get_post_meta($post->ID, 'number_of_pages', true); 
  $jel_code = get_post_meta($post->ID, 'jel_code', true);
  $edition = get_post_meta($post->ID, 'edition', true);
  $editorial = get_post_meta($post->ID, 'editorial', true);
  $organization_name = get_post_meta($post->ID, 'organization_name', true);
  $organization_url = get_post_meta($post->ID, 'organization_url', true);
  $organization_logo = get_post_meta($post->ID, 'organization_logo', true);
  $organization_logo_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($organization_logo));

  $ano = substr($publication_date, 0, 4);
  $mes   = substr($publication_date, 5, 2);
  $dia = substr($publication_date, -2);

  $publication_date = $dia . '/' . $mes . '/' . $ano;

  if($publication_date == "//"){

    $publication_date ='';
  }


  ?>

  <p>
    <label for="publication_date"><?php _e('Fecha de publicación (*)', 'os_publicacion_type'); ?></label>
    <input required type="text" name="publication_date" value="<?php echo $publication_date; ?>" class="widefat" />
    <span class="description">(<?php _e('*Campo obligatorio. Formato: DD/MM/AAAA', 'os_publicacion_type'); ?>)</span>
  </p>
  <p>
    <label for="type"><?php _e('Tipo', 'os_publicacion_type'); ?></label>
    <input type="text" name="type" value="<?php echo $type; ?>" class="widefat" />
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
  <p>
    <label for="organization_name"><?php _e('Nombre de la organización que lo publica', 'os_publicacion_type'); ?></label>
    <input type="text" name="organization_name" value="<?php echo $organization_name; ?>" class="widefat" />
  </p>
  <p>
    <label for="organization_url"><?php _e('URL de la organización que lo publica', 'os_publicacion_type'); ?></label>
    <input type="url" name="organization_url" value="<?php echo $organization_url; ?>" class="widefat" />
  </p>
  <p>
    <label for="organization_logo"><?php _e('Logo de la organización', 'os_publicacion_type'); ?></label>
    <input class="widefat" id="organization_logo" name="organization_logo" type="text" value="<?php if (!empty($organization_logo)) echo $organization_logo; ?>" readonly="readonly"/>
    <img id="show_logo" draggable="false" alt="" name="show_logo" src="<?php if (!empty($organization_logo_thumbnail)) echo esc_attr($organization_logo_thumbnail); ?>" style="<?php if (empty($organization_logo_thumbnail)) echo "display: none;"; ?>">
  </p>
  <p>
    <input id="upload_logo" name="upload_logo" type="button" value="<?php _e('Explorar/Subir', 'os_publicacion_type'); ?>" />
  </p>
  <?php
}


function meta_boxes_save($post_id) {
  if (isset($_POST['abstract_destacado'])) {
    update_post_meta($post_id, 'abstract_destacado', strip_tags($_POST['abstract_destacado']));
  }
  if (isset($_POST['abstract_contenido'])) {
    update_post_meta($post_id, 'abstract_contenido', strip_tags($_POST['abstract_contenido']));
  }
  if (isset($_POST['pdf'])) {
    update_post_meta($post_id, 'pdf', strip_tags($_POST['pdf']));
  }
  if (isset($_POST['pdfInterno'])) {
    update_post_meta($post_id, 'pdfInterno', strip_tags($_POST['pdfInterno']));
  }
  if (isset($_POST['publication_date'])) {


    $publication_date = $_POST['publication_date'];

    $dia = substr($publication_date, 0, 2);
    $mes   = substr($publication_date, 3, 2);
    $ano = substr($publication_date, -4);  
    $publication_date = $ano . '-' . $mes . '-' . $dia;

    update_post_meta($post_id, 'publication_date', strip_tags($publication_date));
  }
  if (isset($_POST['type'])) {
   update_post_meta($post_id, 'type', strip_tags($_POST['type']));
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
  if (isset($_POST['organization_name'])) {
   update_post_meta($post_id, 'organization_name', strip_tags($_POST['organization_name']));
  }
  if (isset($_POST['name_url'])) {
    update_post_meta($post_id, 'name_url', strip_tags($_POST['name_url']));
  }
  if (isset($_POST['source_url'])) {
    update_post_meta($post_id, 'source_url', strip_tags($_POST['source_url']));
  }
  if (isset($_POST['organization_url'])) {
    update_post_meta($post_id, 'organization_url', strip_tags($_POST['organization_url']));
  }
  if (isset($_POST['organization_logo'])) {
   update_post_meta($post_id, 'organization_logo', strip_tags($_POST['organization_logo']));
  }
  if (isset($_POST['imagenCard'])) {
   update_post_meta($post_id, 'imagenCard', strip_tags($_POST['imagenCard']));
  }
  if (isset($_POST['imagenCabecera'])) {
   update_post_meta($post_id, 'imagenCabecera', strip_tags($_POST['imagenCabecera']));
  }
  if (isset($_POST['destacada'])) {
    update_post_meta($post_id, 'destacada', strip_tags($_POST['destacada']));
  } else {
    update_post_meta($post_id, 'destacada', "off");
  }
  if(user_can_save($post_id, 'videoIntro_publicacion-nonce')) {
    if(isset($_POST['videoIntro-url'])) {
      update_post_meta($post_id, 'videoIntro-url', strip_tags($_POST['videoIntro-url']));
    }
  }
  if(user_can_save($post_id, 'video_publicacion-nonce')) {
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
  if (isset($_POST['publicacion_puntosClave'])) {
    $publicacion_puntosClave = $_POST['publicacion_puntosClave'];
    $publicacion_puntosClave_save =  array();
    foreach ($publicacion_puntosClave as $h) {
        if (!empty($h)) {
           array_push($publicacion_puntosClave_save, $h);
        }
    }
    update_post_meta($post_id, 'publicacion_puntosClave', $publicacion_puntosClave_save);
  }

}
add_action('save_post', "meta_boxes_save");
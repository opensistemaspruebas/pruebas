<?php

/*
    Plugin Name: OS Evento Type
    Plugin URI: https://www.opensistemas.com/
    Description: Crea el tipo de contenido 'Evento'.
    Version: 1.0
    Author: Marta Oliver
    Author URI: https://www.opensistemas.com/
    License: GPLv2 or later
    Text Domain: os_evento_type
*/


if (!class_exists('OS_Evento_Type')) {

    class OS_Evento_Type {   
        
        var $post_type = "evento";
        
        function __construct() {
            add_action('init', array(&$this, 'create_post_type'));
            add_action('admin_print_styles', array(&$this, 'register_admin_styles'));
            add_action('admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));
            add_action('plugins_loaded', array(&$this, 'load_text_domain'), 10);
            add_action('add_meta_boxes', array(&$this, 'add_custom_meta_boxes'));
            add_action('save_post', array(&$this, 'meta_boxes_save'));
        }


        function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_evento_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
			$labels = array(
				'name'               => _x('Eventos', 'post type general name', 'os_evento_type'),
				'singular_name'      => _x('Evento', 'post type singular name', 'os_evento_type'),
				'menu_name'          => _x('Eventos', 'admin menu', 'os_evento_type'),
				'name_admin_bar'     => _x('Evento', 'add new on admin bar', 'os_evento_type'),
				'add_new'            => _x('Añadir nuevo', 'book', 'os_evento_type'),
				'add_new_item'       => __('Añadir nuevo evento', 'os_evento_type'),
				'new_item'           => __('Nuevo evento', 'os_evento_type'),
				'edit_item'          => __('Editar evento', 'os_evento_type'),
				'view_item'          => __('Ver evento', 'os_evento_type'),
				'all_items'          => __('Todos los eventos', 'os_evento_type'),
				'search_items'       => __('Buscar eventos', 'os_evento_type'),
				'parent_item_colon'  => __('Evento superior:', 'os_evento_type'),
				'not_found'          => __('No se han encontrado eventos.', 'os_evento_type'),
				'not_found_in_trash' => __('No se han encontrado eventos en la papelera.', 'os_evento_type')
			);
			$args = array(
				'labels'             => $labels,
				'description'        => __('Tipo de contenido para albergar un evento.', 'os_evento_type'),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array('slug' => 'evento'),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array('title'),
                'taxonomies'         => array(),
			);
			register_post_type($this->post_type, $args );
        }


        function register_admin_styles() {
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_style('os-evento-type-css', plugin_dir_url(__FILE__) . 'css/os_evento_type.css');           
            }
        }


        function register_admin_scripts() {
        	global $typenow;
            if ($typenow == $this->post_type) {
                wp_register_script('os_evento_type-js', plugins_url('js/os_evento_type.js' , __FILE__), array('jquery'));           
                wp_enqueue_script('os_evento_type-js');
            }
        }


        function add_custom_meta_boxes() {
        	add_meta_box('evento_video_o_imagen_de_cabecera',  __('Cabecera del evento', 'os_evento_type'), array(&$this, 'meta_box_evento_video_o_imagen_de_cabecera'), 'evento', 'normal', 'high');
        	add_meta_box('evento_descripcion',  __('Descripción del evento', 'os_evento_type'), array(&$this, 'meta_box_evento_descripcion'), 'evento', 'normal', 'high');
			add_meta_box('evento_documento',  __('Documento', 'os_evento_type'), array(&$this, 'meta_box_evento_documento'), 'evento', 'normal', 'high');
			add_meta_box('evento_localizacion',  __('Localización', 'os_evento_type'), array(&$this, 'meta_box_evento_localizacion'), 'evento', 'normal', 'high');
        	add_meta_box('evento_programa',  __('Programa del evento', 'os_evento_type'), array(&$this, 'meta_box_evento_programa'), 'evento', 'normal', 'high');
            add_meta_box('evento_persona_de_contacto',  __('Persona de contacto', 'os_evento_type'), array(&$this, 'meta_box_evento_persona_de_contacto'), 'evento', 'normal', 'high');
		}


		function meta_box_evento_video_o_imagen_de_cabecera($post) {
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_video_o_imagen_de_cabecera-nonce');
		  	$videoIntro_url = get_post_meta($post->ID, 'videoIntro-url', true);
			$video_type = get_post_meta($post->ID,'video-type',true); 
			if ($video_type == '') {
				$video_type = 'youtube';
			}
			$wp_video_url = get_post_meta($post->ID,'wp-video-url',true);
			$yt_video_url = get_post_meta($post->ID,'yt-video-url',true);
			$imagenCard = get_post_meta($post->ID, 'imagenCard', true);
			$imagen_card_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCard));
			$imagenCabecera = get_post_meta($post->ID, 'imagenCabecera', true);
			$imagen_cabecera_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCabecera));
		 	$imagenCard = get_post_meta($post->ID, 'imagenCard', true);
			$imagen_card_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCard));
			$evento_fecha_de_inicio = get_post_meta($post->ID, 'evento_fecha_de_inicio', true);
			$evento_fecha_de_final = get_post_meta($post->ID, 'evento_fecha_de_final', true);
			$evento_localizacion = get_post_meta($post->ID, 'evento_localizacion', true);
		 	$evento_url_registro = get_post_meta($post->ID, 'evento_url_registro', true);
		 	
		 	?>
		 	<h1><?php _e('Vídeo de introducción', 'os_evento_type'); ?></h1>
		 	<p><?php _e('Es el video que se mostrará al cargar la página en estado autoplay.','os_evento_type'); ?></p>
			<p class="videoIntro-wordpress">
				<label for="videoIntro-url"><?php _e('URL del vídeo', 'os_evento_type'); ?></label>
				<input class="widefat" id="videoIntro-url" name="videoIntro-url" type="text" value="<?php if (isset($videoIntro_url)) echo $videoIntro_url; ?>" readonly />
			</p>    
			<p class="videoIntro-wordpress">
				<input id="upload_videoIntroEvento" name="upload_videoIntroEvento" type="button" value="<?php _e('Explorar/Subir', 'os_evento_type'); ?>" />
			</p>
			<h1><?php _e('Vídeo completo', 'os_evento_type'); ?></h1>
			<p><?php _e('Este video aparecerá al hacer click sobre el icono play. Aparecerá en una ventana modal.','os_evento_type'); ?></p>
		    <p>
		      <label for="video-type"><?php _e('Fuente: ','os_evento_type'); ?></label>
		      <input type="radio" name="video-type" id="video-type-yt" value="youtube" <?php if ( !empty ( $video_type ) ) { checked( $video_type, 'youtube' );} ?>>
		      <label for="video-type-yt"><?php _e( 'Youtube', 'os_evento_type' )?></label>
		      <input type="radio" name="video-type" id="video-type-wp" value="wordpress" <?php if ( !empty ( $video_type ) ) { checked( $video_type, 'wordpress' ); } ?>>
		      <label for="video-type-wp"><?php _e( 'Wordpress', 'os_evento_type' )?></label>
		    </p>
		    <p class="video-youtube" <?php if ($video_type != 'youtube') { echo 'style="display: none;"'; } ?>>
		      <label for="yt-video-url"><?php _e('Enlace de Youtube', 'os_evento_type'); ?></label>
		      <input class="widefat" id="yt-video-url" name="yt-video-url" type="text" value="<?php if (isset($yt_video_url)) echo $yt_video_url; ?>"/>
		      <i><?php _e('Si el campo "Video cabecera" está relleno, se mostrará este en vez de "Imagen cabecera"','os_evento_type'); ?></i>
		    </p>

		    <p class="video-wordpress" <?php if ($video_type != 'wordpress') { echo 'style="display: none;"'; } ?>>
		      <label for="wp-video-url"><?php _e('URL video', 'os_evento_type'); ?></label>
		      <input class="widefat" id="wp-video-url" name="wp-video-url" type="text" value="<?php if (isset($wp_video_url)) echo $wp_video_url; ?>" readonly />
		    </p>    
		    <p class="video-wordpress" <?php if ($video_type != 'wordpress') { echo 'style="display: none;"'; } ?>>
		      <input id="upload_videoEvento" name="upload_videoEvento" type="button" value="<?php _e('Explorar/Subir', 'os_evento_type'); ?>" />
		    </p>
		 	<h1><?php _e('Imagen estática', 'os_evento_type'); ?></h1>
			<p><?php _e('Esta es la imagen que se muestra en la cabecera de la página de detalle del evento. Si hay un vídeo, se mostrará el vídeo en lugar de ésta.','os_evento_type'); ?></p>
			<p>
				<label for="imagenCabecera"><?php _e('URL de una imagen alojada en WordPress', 'os_evento_type'); ?></label>
				<input class="widefat" id="imagenCabecera" name="imagenCabecera" type="text" value="<?php if (!empty($imagenCabecera)) echo $imagenCabecera; ?>" readonly="readonly"/>
				<img id="show_imagenCabecera" draggable="false" alt="" name="show_imagenCabecera" src="<?php if (!empty($imagen_cabecera_thumbnail)) echo esc_attr($imagen_cabecera_thumbnail); ?>" style="<?php if (empty($imagen_cabecera_thumbnail)) echo "display: none;"; ?>">
			</p>
			<p>
				<input id="upload_evento_imagenCabecera" name="upload_evento_imagenCabecera" type="button" value="<?php _e('Explorar/Subir', 'os_evento_type'); ?>" />
			</p>
			<h1><?php _e('Imagen para tarjeta', 'os_evento_type'); ?></h1>
			<p><?php _e('Esta es la imagen que se muestra en la tarjeta del evento.','os_evento_type'); ?></p>
			<p>
				<label for="imagenCard"><?php _e('URL de una imagen alojada en WordPress', 'os_evento_type'); ?></label>
				<input class="widefat" id="imagenCard" name="imagenCard" type="text" value="<?php if (!empty($imagenCard)) echo $imagenCard; ?>" readonly="readonly"/>
				<img id="show_imagenCard" draggable="false" alt="" name="show_imagenCard" src="<?php if (!empty($imagen_card_thumbnail)) echo esc_attr($imagen_card_thumbnail); ?>" style="<?php if (empty($imagen_card_thumbnail)) echo "display: none;"; ?>">
			</p>
			<p>
				<input id="upload_evento_imagenCard" name="upload_evento_imagenCard" type="button" value="<?php _e('Explorar/Subir', 'os_evento_type'); ?>" />
			</p>
			<h1><?php _e('Fecha', 'os_evento_type'); ?></h1>
			<p><?php _e('Este es el rango de fechas de cuándo tendrá lugar el evento.', 'os_evento_type'); ?></p>
			<p>
				<label class="classfat" for="evento_fecha_de_inicio"><?php _e('Fecha de inicio (*)', 'os_evento_type'); ?></label>
				<input required type="date" id="evento_fecha_de_inicio" name="evento_fecha_de_inicio" class="widefat" value="<?php echo $evento_fecha_de_inicio; ?>">
				<span class="description">(<?php _e('*Campo obligatorio. Formato: DD/MM/AAAA', 'os_evento_type'); ?>)</span>
			</p>
			<p>
				<label class="classfat" for="evento_fecha_de_final"><?php _e('Fecha de final (*)', 'os_evento_type'); ?></label>
				<input required type="date" id="evento_fecha_de_final" name="evento_fecha_de_final" class="widefat" value="<?php echo $evento_fecha_de_final; ?>">
				<span class="description">(<?php _e('*Campo obligatorio. Formato: DD/MM/AAAA', 'os_evento_type'); ?>)</span>
			</p>
		 	<h1><?php _e('Lugar', 'os_evento_type'); ?></h1>
			<p>
				<label class="classfat" for="evento_localizacion[2]"><?php _e('Ciudad (*)', 'os_evento_type'); ?></label>
				<input required type="text" id="evento_localizacion[2]" name="evento_localizacion[2]" class="widefat" placeholder="<?php _e('Ciudad', 'os_evento_type'); ?>" value="<?php echo $evento_localizacion[2]; ?>">
				<span class="description">(<?php _e('*Campo obligatorio. Por ejemplo: Madrid', 'os_evento_type'); ?>)</span>
			</p>
		 	<h1><?php _e('Registro', 'os_evento_type'); ?></h1>
			<p><?php _e('Este es la URL del enlace para registrarse en el evento.', 'os_evento_type'); ?></p>
			<p>
				<label class="classfat" for="evento_url_registro"><?php _e('URL', 'os_evento_type'); ?></label>
				<input type="url" id="evento_url_registro" name="evento_url_registro" class="widefat" placeholder="<?php _e('URL', 'os_evento_type'); ?>" value="<?php echo $evento_url_registro; ?>">
				<span class="description">(<?php _e('Por ejemplo: http://www.example.com/', 'os_evento_type'); ?>)</span>
			</p>
			<?php 
		}


		function meta_box_evento_descripcion($post) {
			
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_descripcion-nonce');
			
			$evento_descripcion_corta = get_post_meta($post->ID, 'evento_descripcion_corta', true);
			$evento_descripcion_larga = get_post_meta($post->ID, 'evento_descripcion_larga', true);
			$editor_id = 'mycustomeditor';
			$settings = array( 
				'teeny'=>false,
				'media_buttons' => false,
				'quicktags' => false,
				'textarea_rows' => 15,
				'tinymce' => array(
					'toolbar1' => 'bold,italic,underline',
					'toolbar2' => false
				),
			);
			$evento_topics = get_post_meta($post->ID, 'evento_topics', true);
			$evento_te_interesa = get_post_meta($post->ID, 'evento_te_interesa', true);
			$evento_highlights = get_post_meta($post->ID, 'evento_highlights', true);
			
			?>
			<h1><?php _e('Descripción corta (*)', 'os_evento_type'); ?></h1>
			<p><?php _e('Este es el texto introductorio que aparecerá en la tarjeta que muestra el resumen del evento.', 'os_evento_type'); ?></p>
			<label class="screen-reader-text" for="evento_descripcion_corta"><?php _e('Descripción corta del evento', 'os_evento_type'); ?></label>
			<textarea required rows="1" cols="40" maxlength="280" name="evento_descripcion_corta" id="evento_descripcion_corta"><?php echo $evento_descripcion_corta; ?></textarea>
			<span class="description">(<?php _e('*Campo obligatorio. Máx. 300 carácteres', 'os_evento_type'); ?>)</span>
			<h1><?php _e('Descripción larga', 'os_evento_type'); ?></h1>
			<p><?php _e('Este es el texto descriptivo que aparecerá en la página de detalle del evento.', 'os_evento_type'); ?></p>
			<?php wp_editor($evento_descripcion_larga, 'eventodescripcionlarga', $settings); ?>
			<h1><?php _e('Topics', 'os_evento_type'); ?></h1>
			<p><?php _e('Estos son los topics del evento.', 'os_evento_type'); ?></p>
			<input type="text" id="evento_topics[0]" name="evento_topics[0]" class="widefat" placeholder="<?php _e('Topic 1', 'os_evento_type'); ?>" value="<?php echo $evento_topics[0]; ?>">
			<input type="text" id="evento_topics[1]" name="evento_topics[1]" class="widefat" placeholder="<?php _e('Topic 2', 'os_evento_type'); ?>" value="<?php echo $evento_topics[1]; ?>">
			<input type="text" id="evento_topics[2]" name="evento_topics[2]" class="widefat" placeholder="<?php _e('Topic 3', 'os_evento_type'); ?>" value="<?php echo $evento_topics[2]; ?>">
			<h1><?php _e('Te interesa', 'os_evento_type'); ?></h1>
			<p><?php _e('Estos son los tres temas que puedan resultar intersantes del evento.', 'os_evento_type'); ?></p>
			<input type="text" id="evento_te_interesa[0]" name="evento_te_interesa[0]" class="widefat" placeholder="<?php _e('Te interesa 1', 'os_evento_type'); ?>" value="<?php echo $evento_te_interesa[0]; ?>">
			<input type="text" id="evento_te_interesa[1]" name="evento_te_interesa[1]" class="widefat" placeholder="<?php _e('Te interesa 2', 'os_evento_type'); ?>" value="<?php echo $evento_te_interesa[1]; ?>">
			<input type="text" id="evento_te_interesa[2]" name="evento_te_interesa[2]" class="widefat" placeholder="<?php _e('Te interesa 3', 'os_evento_type'); ?>" value="<?php echo $evento_te_interesa[2]; ?>">
			<h1><?php _e('Highlights', 'os_evento_type'); ?></h1>
			<p><?php _e('Estos son los highlights del evento.', 'os_evento_type'); ?></p>
			<input type="text" id="evento_highlights[0]" name="evento_highlights[0]" class="widefat" placeholder="<?php _e('Highlight 1', 'os_evento_type'); ?>" value="<?php echo $evento_highlights[0]; ?>">
			<input type="text" id="evento_highlights[1]" name="evento_highlights[1]" class="widefat" placeholder="<?php _e('Highlight 2', 'os_evento_type'); ?>" value="<?php echo $evento_highlights[1]; ?>">
			<input type="text" id="evento_highlights[2]" name="evento_highlights[2]" class="widefat" placeholder="<?php _e('Highlight 3', 'os_evento_type'); ?>" value="<?php echo $evento_highlights[2]; ?>">
			<?php
		}


		function meta_box_evento_documento($post) {
			wp_nonce_field( basename( __FILE__ ), 'meta_box_evento_documento-nonce');
			$evento_documento = get_post_meta($post->ID, 'evento_documento', true); 
			?>
			<p><?php _e('Este es el enlace al documento de la ficha que se muestra en la página de detalle del evento.','os_evento_type'); ?></p>
			<p>
				<label for="evento_documento"><?php _e('URL de un documento alojado en WordPress', 'os_evento_type'); ?></label>
				<input class="widefat" id="evento_documento" name="evento_documento" type="text" value="<?php if (!empty($evento_documento)) echo $evento_documento; ?>" readonly="readonly"/>
			</p>
			<p>
				<input id="upload_evento_documento" name="upload_evento_documento" type="button" value="<?php _e('Explorar/Subir', 'os_evento_type'); ?>" />
			</p>
			<?php
		}


		function meta_box_evento_localizacion($post) {
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_localizacion-nonce');
			$evento_localizacion = get_post_meta($post->ID, 'evento_localizacion', true);
			?>
			<p><?php _e('Esta es la localización del evento. Los campos de título y dirección se mostrarán de manera informativa en los widgets y páginas de detalle de eventos.', 'os_evento_type'); ?></p>
			<p><?php _e('Para colocar el tooltip del mapa en la página de detalle de evento futuro se utilizarán los campos de latitud, longitud y distancia.', 'os_evento_type'); ?></p>
			<p>
				<label class="classfat" for="evento_localizacion[0]"><?php _e('Título de la localización', 'os_evento_type'); ?></label>
				<input type="text" id="evento_localizacion[0]" name="evento_localizacion[0]" class="widefat" placeholder="<?php _e('Título', 'os_evento_type'); ?>" value="<?php echo $evento_localizacion[0]; ?>">
				<span class="description">(<?php _e('Por ejemplo: Bancomer Educación Financiera', 'os_evento_type'); ?>)</span>
			</p>
			<p>
				<label class="classfat" for="evento_localizacion[1]"><?php _e('Dirección de la localización', 'os_evento_type'); ?></label>
				<input type="text" id="evento_localizacion[1]" name="evento_localizacion[1]" class="widefat" placeholder="<?php _e('Dirección', 'os_evento_type'); ?>" value="<?php echo $evento_localizacion[1]; ?>">
				<span class="description">(<?php _e('Por ejemplo: 30 South 14th St, México D.F, AL, 35233', 'os_evento_type'); ?>)</span>
			</p>
			<p>
				<label class="classfat" for="evento_localizacion[3]"><?php _e('Latitud', 'os_evento_type'); ?></label>
				<input type="number" step="any" id="evento_localizacion[3]" name="evento_localizacion[3]" class="widefat" placeholder="<?php _e('Latitud', 'os_evento_type'); ?>" value="<?php echo $evento_localizacion[3]; ?>">
				<span class="description">(<?php _e('Por ejemplo: -34.397', 'os_evento_type'); ?>)</span>
			</p>
			<p>
				<label class="classfat" for="evento_localizacion[4]"><?php _e('Longitud', 'os_evento_type'); ?></label>
				<input type="number" step="any" id="evento_localizacion[4]" name="evento_localizacion[4]" class="widefat" placeholder="<?php _e('Longitud', 'os_evento_type'); ?>" value="<?php echo $evento_localizacion[4]; ?>">
				<span class="description">(<?php _e('Por ejemplo: 150.644', 'os_evento_type'); ?>)</span>
			</p>
			<p>
				<label class="classfat" for="evento_localizacion[5]"><?php _e('Distancia', 'os_evento_type'); ?></label>
				<input type="text" step="any" id="evento_localizacion[5]" name="evento_localizacion[5]" class="widefat" placeholder="<?php _e('Distancia', 'os_evento_type'); ?>" value="<?php echo $evento_localizacion[5]; ?>">
				<span class="description">(<?php _e('Por ejemplo: 2.8 Miles', 'os_evento_type'); ?>)</span>
			</p>
			<?php   
		}


		function meta_box_evento_persona_de_contacto($post) {
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_persona_de_contacto-nonce');
			$evento_persona_de_contacto = get_post_meta($post->ID, 'evento_persona_de_contacto', true);
			$imagen_perfil = $evento_persona_de_contacto[2];
			$imagen_perfil_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagen_perfil));
			?>
			<p><?php _e('Esta es la persona de contacto del evento.','os_evento_type'); ?></p>
			<p>
				<label class="classfat" for="evento_persona_de_contacto[0]"><?php _e('Nombre y apellidos', 'os_evento_type'); ?></label>
				<input type="text" id="evento_persona_de_contacto[0]" name="evento_persona_de_contacto[0]" class="widefat" placeholder="<?php _e('Nombre Apellido', 'os_evento_type'); ?>" value="<?php echo $evento_persona_de_contacto[0]; ?>">
				<span class="description">(<?php _e('Por ejemplo: John Deer', 'os_evento_type'); ?>)</span>
			</p>
			<p>
				<label class="classfat" for="evento_persona_de_contacto[1]"><?php _e('Cargo/Estudios', 'os_evento_type'); ?></label>
				<input type="text" id="evento_persona_de_contacto[1]" name="evento_persona_de_contacto[1]" class="widefat" placeholder="<?php _e('Cargo/Estudios', 'os_evento_type'); ?>" value="<?php echo $evento_persona_de_contacto[1]; ?>">
				<span class="description">(<?php _e('Por ejemplo: Doctora honoris causa de estadística por la Universidad Complutense', 'os_evento_type'); ?>)</span>
			</p>
			<p>
				<label for="evento_persona_de_contacto[2]"><?php _e('Imagen de perfil', 'os_evento_type'); ?></label>
				<input class="widefat" id="evento_persona_de_contacto[2]" name="evento_persona_de_contacto[2]" type="text" value="<?php if (!empty($imagen_perfil)) echo $imagen_perfil; ?>" readonly="readonly"/>
				<img id="show_imagen_perfil" draggable="false" alt="" name="show_imagen_perfil" src="<?php if (!empty($imagen_perfil_thumbnail)) echo esc_attr($imagen_perfil_thumbnail); ?>" style="<?php if (empty($imagen_perfil_thumbnail)) echo "display: none;"; ?>">
			</p>
			<p>
				<input id="upload_evento_imagen_perfil" name="upload_evento_imagen_perfil" type="button" value="<?php _e('Explorar/Subir', 'os_evento_type'); ?>" />
			</p>
			<?php
		}


		function meta_box_evento_programa($post) {
			wp_nonce_field( basename( __FILE__ ), 'meta_box_evento_programa-nonce');
			$evento_elemento_programa = get_post_meta($post->ID, 'evento_elemento_programa', true); 
			$ponentes = query_posts(
				array(
					'post_type'=> 'guest-author',
					'perfil' => 'ponente',
					'orderby' => 'title',
					'order'    => 'ASC'
				)
			);
			?>
			<p><?php _e('Este es el programa del evento.','os_evento_type'); ?></p>
			<?php if (empty($evento_elemento_programa)) : ?>
				<div class="elementos_de_programa">
				    <p class="radiobuttons">
				      <input type="radio" name="evento_elemento_programa[0][tipo]" id="ponencia" value="ponencia" checked>
				      <?php _e('Ponencia', 'os_evento_type')?><br>
				      <input type="radio" name="evento_elemento_programa[0][tipo]" id="descanso" value="descanso">
				      <?php _e('Descanso', 'os_evento_type')?><br>
				    </p>
					<p>
						<label for="evento_elemento_programa[0][inicio]"><?php _e('Hora de inicio', 'os_evento_type'); ?></label>
						<input class="widefat" id="evento_elemento_programa[0][inicio]" name="evento_elemento_programa[0][inicio]" type="time" value="" />
						<span class="description">(<?php _e('Formato: HH:MM', 'os_evento_type'); ?>)</span>
					</p>
					<p>
						<label for="evento_elemento_programa[0][duracion]"><?php _e('Duración', 'os_evento_type'); ?></label>
						<input class="widefat" id="evento_elemento_programa[0][duracion]" name="evento_elemento_programa[0][duracion]" type="text" value="" />
						<span class="description">(<?php _e('Por ejemplo: 15min', 'os_evento_type'); ?>)</span>
					</p>
					<p>
						<label for="evento_elemento_programa[0][titulo]"><?php _e('Titulo', 'os_evento_type'); ?></label>
						<input class="widefat" id="evento_elemento_programa[0][titulo]" name="evento_elemento_programa[0][titulo]" type="text" value="" />
					</p>
					<p>
						<label for="evento_elemento_programa[0][descripcion]"><?php _e('Descripción', 'os_evento_type'); ?></label>
						<textarea rows="1" cols="40" maxlength="280" name="evento_elemento_programa[0][descripcion]" id="evento_elemento_programa[0][descripcion]"></textarea>
					</p>
					<p>
						<label for="evento_elemento_programa[0][ponentes]"><?php _e('Ponentes', 'os_evento_type'); ?></label>
						<select class="widefat ponentes" id="evento_elemento_programa[0][ponentes][]" name="evento_elemento_programa[0][ponentes][]" multiple="multiple">
						<?php
						if (!empty($ponentes)) {
							foreach ($ponentes as $p) {
								?>
								<option value="<?php echo $p->ID; ?>"><?php echo $p->post_title; ?></option>
								<?php
							}
						}
						?>
						</select>
					</p>
					<p>
						<label for="evento_elemento_programa[0][moderador]"><?php _e('Moderador', 'os_evento_type'); ?></label>
						<input class="widefat" id="evento_elemento_programa[0][moderador]" name="evento_elemento_programa[0][moderador]" type="text" value="" />
					</p>
				</div>
	            <p>
	                <button id="add-elemento-programa" type="button"><?php _e('Añadir elemento', 'os_evento_type')?></button>
	            </p>
			<?php else : ?>
			<?php $i = 0; ?>
			<?php foreach ($evento_elemento_programa as $e) : ?>
				<div class="elementos_de_programa">
				    <p class="radiobuttons">
				      <input type="radio" name="evento_elemento_programa[<?php echo $i; ?>][tipo]" id="ponencia" value="ponencia" <?php if (!empty($evento_elemento_programa[$i]['tipo'])) checked($evento_elemento_programa[$i]['tipo'], 'ponencia'); else echo "checked"; ?>>
				      <?php _e('Ponencia', 'os_evento_type')?><br>
				      <input type="radio" name="evento_elemento_programa[<?php echo $i; ?>][tipo]" id="descanso" value="descanso" <?php if (!empty($evento_elemento_programa[$i]['tipo'])) checked($evento_elemento_programa[$i]['tipo'], 'descanso'); ?>>
				      <?php _e('Descanso', 'os_evento_type')?><br>
				    </p>
					<p>
						<label for="evento_elemento_programa[<?php echo $i; ?>][inicio]"><?php _e('Hora de inicio', 'os_evento_type'); ?></label>
						<input class="widefat" id="evento_elemento_programa[<?php echo $i; ?>][inicio]" name="evento_elemento_programa[<?php echo $i; ?>][inicio]" type="time" value="<?php if (!empty($evento_elemento_programa[$i]['inicio'])) echo $evento_elemento_programa[$i]['inicio']; ?>" />
						<span class="description">(<?php _e('Formato: HH:MM', 'os_evento_type'); ?>)</span>
					</p>
					<p>
						<label for="evento_elemento_programa[<?php echo $i; ?>][duracion]"><?php _e('Duración', 'os_evento_type'); ?></label>
						<input class="widefat" id="evento_elemento_programa[<?php echo $i; ?>][duracion]" name="evento_elemento_programa[<?php echo $i; ?>][duracion]" type="text" value="<?php if (!empty($evento_elemento_programa[$i]['duracion'])) echo $evento_elemento_programa[$i]['duracion']; ?>" />
						<span class="description">(<?php _e('Por ejemplo: 15min', 'os_evento_type'); ?>)</span>
					</p>
					<p>
						<label for="evento_elemento_programa[<?php echo $i; ?>][titulo]"><?php _e('Titulo', 'os_evento_type'); ?></label>
						<input class="widefat" id="evento_elemento_programa[<?php echo $i; ?>][titulo]" name="evento_elemento_programa[<?php echo $i; ?>][titulo]" type="text" value="<?php if (!empty($evento_elemento_programa[$i]['titulo'])) echo $evento_elemento_programa[$i]['titulo']; ?>" />
					</p>
					<p <?php if ($evento_elemento_programa[$i]['tipo'] == 'descanso') echo 'style="display:none;"' ?>>
						<label for="evento_elemento_programa[<?php echo $i; ?>][descripcion]"><?php _e('Descripción', 'os_evento_type'); ?></label>
						<textarea rows="1" cols="40" maxlength="280" name="evento_elemento_programa[<?php echo $i; ?>][descripcion]" id="evento_elemento_programa[<?php echo $i; ?>][descripcion]"><?php if (!empty($evento_elemento_programa[$i]['descripcion'])) echo $evento_elemento_programa[$i]['descripcion']; ?></textarea>
					</p>
					<p <?php if ($evento_elemento_programa[$i]['tipo'] == 'descanso') echo 'style="display:none;"' ?>>
						<label for="evento_elemento_programa[<?php echo $i; ?>][ponentes]"><?php _e('Ponentes', 'os_evento_type'); ?></label>
						<select class="widefat ponentes" id="evento_elemento_programa[<?php echo $i; ?>][ponentes][]" name="evento_elemento_programa[<?php echo $i; ?>][ponentes][]" multiple="multiple">
						<?php
						if (!empty($ponentes)) {
							foreach ($ponentes as $p) {								?>
								<option value="<?php echo $p->ID; ?>" <?php if (!empty($evento_elemento_programa[$i]['ponentes'])) if (in_array($p->ID, $evento_elemento_programa[$i]['ponentes'])) echo "selected"; ?>><?php echo $p->post_title; ?></option>
								<?php
							}
						}
						?>
						</select>
					</p>
					<p <?php if ($evento_elemento_programa[$i]['tipo'] == 'descanso') echo 'style="display:none;"' ?>>
						<label for="evento_elemento_programa[<?php echo $i; ?>][moderador]"><?php _e('Moderador', 'os_evento_type'); ?></label>
						<input class="widefat" id="evento_elemento_programa[<?php echo $i; ?>][moderador]" name="evento_elemento_programa[<?php echo $i; ?>][moderador]" type="text" value="<?php if (!empty($evento_elemento_programa[$i]['moderador'])) echo $evento_elemento_programa[$i]['moderador']; ?>" />
					</p>
				    <?php if ($i > 0) : ?>
                        <button id="delete-elemento-programa" type="button"><?php _e('Eliminar este elemento', 'os_evento_type'); ?></button>
                    <?php endif; ?>
				</div>
	            <?php $i++; ?>
			<?php endforeach; ?>
				<p>
	                <button id="add-elemento-programa" type="button"><?php _e('Añadir elemento', 'os_evento_type')?></button>
	            </p>
			<?php endif; ?>
			<?php
		}


		function meta_boxes_save($post_id) {

			if (isset($_POST['evento_url_registro'])) {
				update_post_meta($post_id, 'evento_url_registro', strip_tags($_POST['evento_url_registro']));
			}

			if (isset($_POST['imagenCard'])) {
				update_post_meta($post_id, 'imagenCard', strip_tags($_POST['imagenCard']));
			}

		    if (isset($_POST['imagenCabecera'])) {
		    	update_post_meta($post_id, 'imagenCabecera', strip_tags($_POST['imagenCabecera']));
		    }

		    if (isset($_POST['evento_documento'])) {
		    	update_post_meta($post_id, 'evento_documento', strip_tags($_POST['evento_documento']));
		    }

			if (isset($_POST['video-type'])) {
				update_post_meta($post_id, 'video-type', strip_tags($_POST['video-type']));
				if ($_POST['video-type'] == 'youtube') {
					if (isset($_POST['yt-video-url'])) {
					  update_post_meta($post_id, 'yt-video-url', strip_tags($_POST['yt-video-url']));
					}
				} else if ($_POST['video-type'] == 'wordpress') {
					if (isset($_POST['wp-video-url'])) {
					  update_post_meta($post_id, 'wp-video-url', strip_tags($_POST['wp-video-url']));
					}
				}
			}

			if (user_can_save($post_id, 'videoIntro_historia-nonce')) {
				if (isset($_POST['videoIntro-url'])) {
					update_post_meta($post_id, 'videoIntro-url', strip_tags($_POST['videoIntro-url']));
				}
			}

			if (isset($_POST['evento_fecha_de_inicio'])) {
				update_post_meta($post_id, 'evento_fecha_de_inicio', strip_tags($_POST['evento_fecha_de_inicio']));
			}

			if (isset($_POST['evento_fecha_de_final'])) {
				update_post_meta($post_id, 'evento_fecha_de_final', strip_tags($_POST['evento_fecha_de_final']));
			}

			if (isset($_POST['evento_localizacion'])) {
				$evento_localizacion = $_POST['evento_localizacion'];
				for ($i = 2; $i < 6; $i++) { 
					$evento_localizacion[$i] = str_replace(',', '.', $evento_localizacion[$i]);
				}
				update_post_meta($post_id, 'evento_localizacion', $evento_localizacion);
			}
			
			if (isset($_POST['evento_descripcion_corta'])) {
				update_post_meta($post_id, 'evento_descripcion_corta', strip_tags($_POST['evento_descripcion_corta']));
			}
			
			if (isset($_POST['eventodescripcionlarga'])) {
				update_post_meta($post_id, 'evento_descripcion_larga', $_POST['eventodescripcionlarga']);
			}

	        if (isset($_POST['evento_topics'])) {
	            $evento_topics = $_POST['evento_topics'];
	            $evento_topics_save =  array();
	            foreach ($evento_topics as $p) {
	                if (!empty($p)) {
	                    array_push($evento_topics_save, $p);
	                }
	            }
	            update_post_meta($post_id, 'evento_topics', $evento_topics_save);
	        }
	        
	        if (isset($_POST['evento_highlights'])) {
	            $evento_highlights = $_POST['evento_highlights'];
	            $evento_highlights_save =  array();
	            foreach ($evento_highlights as $h) {
	                if (!empty($h)) {
	                    array_push($evento_highlights_save, $h);
	                }
	            }
	            update_post_meta($post_id, 'evento_highlights', $evento_highlights_save);
	        }

	        if (isset($_POST['evento_te_interesa'])) {
	            $evento_te_interesa = $_POST['evento_te_interesa'];
	            $evento_te_interesa_save =  array();
	            foreach ($evento_te_interesa as $t) {
	                if (!empty($t)) {
	                    array_push($evento_te_interesa_save, $t);
	                }
	            }
	            update_post_meta($post_id, 'evento_te_interesa', $evento_te_interesa_save);
	        }

			if (isset($_POST['evento_persona_de_contacto'])) {
				update_post_meta($post_id, 'evento_persona_de_contacto', $_POST['evento_persona_de_contacto']);
			}

			if (isset($_POST['evento_elemento_programa'])) {
	            $evento_elemento_programa = $_POST['evento_elemento_programa'];
	            $evento_elemento_programa_save = array();
	            foreach ($evento_elemento_programa as $e) {
	                if (!(empty($e['titulo']))) {
	                    array_push($evento_elemento_programa_save, $e);
	                }
	            }
	            update_post_meta($post_id, 'evento_elemento_programa', $evento_elemento_programa_save);
	        }
		}

    }

    $os_evento_type = new OS_Evento_Type();

}
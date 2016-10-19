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
                'taxonomies'         => false,
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
            add_meta_box('evento_imagen_card',  __('Imagen para tarjeta', 'os_evento_type'), array(&$this, 'meta_box_evento_imagen_card'), 'evento', 'normal', 'high');
        	add_meta_box('evento_imagen',  __('Imagen de cabecera', 'os_evento_type'), array(&$this, 'meta_box_evento_imagen'), 'evento', 'normal', 'high');
        	add_meta_box('evento_video',  __('Vídeo de cabecera', 'os_evento_type'), array(&$this, 'meta_box_evento_video'), 'evento', 'normal', 'high');
        	add_meta_box('evento_documento',  __('Documento', 'os_evento_type'), array(&$this, 'meta_box_evento_documento'), 'evento', 'normal', 'high');
        	add_meta_box('evento_fecha',  __('Fecha del evento', 'os_evento_type'), array(&$this, 'meta_box_evento_fecha'), 'evento', 'normal', 'high');
			add_meta_box('evento_localizacion',  __('Localización del evento', 'os_evento_type'), array(&$this, 'meta_box_evento_localizacion'), 'evento', 'normal', 'high');
			add_meta_box('evento_descripcion_corta',  __('Descripción corta del evento', 'os_evento_type'), array(&$this, 'meta_box_evento_descripcion_corta'), 'evento', 'normal', 'high');
			add_meta_box('evento_descripcion_corta',  __('Descripción corta del evento', 'os_evento_type'), array(&$this, 'meta_box_evento_descripcion_corta'), 'evento', 'normal', 'high');
			add_meta_box('evento_descripcion_larga',  __('Descripción larga del evento', 'os_evento_type'), array(&$this, 'meta_box_evento_descripcion_larga'), 'evento', 'normal', 'high');
			add_meta_box('evento_topics',  __('Topics', 'os_evento_type'), array(&$this, 'meta_box_evento_topics'), 'evento', 'side', 'high');
			add_meta_box('evento_highlights',  __('Highlights', 'os_evento_type'), array(&$this, 'meta_box_evento_highlights'), 'evento', 'side', 'high');
			add_meta_box('evento_te_interesa',  __('Te interesa', 'os_evento_type'), array(&$this, 'meta_box_evento_te_interesa'), 'evento', 'side', 'high');
		}



		function meta_box_evento_imagen_card($post) {         
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_imagen_card-nonce');
			$imagenCard = get_post_meta($post->ID, 'imagenCard', true);
			$imagen_card_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCard));
			?>
			<p><?php _e('Esta es la imagen que se muestra en la tarjeta del evento.','os_evento_type'); ?></p>
			<p>
				<label for="imagenCard"><?php _e('URL de una imagen alojada en WordPress', 'os_evento_type'); ?></label>
				<input class="widefat" id="imagenCard" name="imagenCard" type="text" value="<?php if (!empty($imagenCard)) echo $imagenCard; ?>" readonly="readonly"/>
				<img id="show_imagenCard" draggable="false" alt="" name="show_imagenCard" src="<?php if (!empty($imagen_card_thumbnail)) echo esc_attr($imagen_card_thumbnail); ?>" style="<?php if (empty($imagen_card_thumbnail)) echo "display: none;"; ?>">
			</p>
			<p>
				<input id="upload_evento_imagenCard" name="upload_evento_imagenCard" type="button" value="<?php _e('Explorar/Subir', 'os_evento_type'); ?>" />
			</p>
			<?php
		}


		
		function meta_box_evento_imagen($post) {         
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_imagen-nonce');
			$imagenCabecera = get_post_meta($post->ID, 'imagenCabecera', true);
			$imagen_cabecera_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCabecera));
			?>
			<p><?php _e('Esta es la imagen que se muestra en la cabecera de la página de detalle del evento. Si hay un vídeo, se mostrará el vídeo en lugar de ésta.','os_evento_type'); ?></p>
			<p>
				<label for="imagenCabecera"><?php _e('URL de una imagen alojada en WordPress', 'os_evento_type'); ?></label>
				<input class="widefat" id="imagenCabecera" name="imagenCabecera" type="text" value="<?php if (!empty($imagenCabecera)) echo $imagenCabecera; ?>" readonly="readonly"/>
				<img id="show_imagenCabecera" draggable="false" alt="" name="show_imagenCabecera" src="<?php if (!empty($imagen_cabecera_thumbnail)) echo esc_attr($imagen_cabecera_thumbnail); ?>" style="<?php if (empty($imagen_cabecera_thumbnail)) echo "display: none;"; ?>">
			</p>
			<p>
				<input id="upload_evento_imagenCabecera" name="upload_evento_imagenCabecera" type="button" value="<?php _e('Explorar/Subir', 'os_evento_type'); ?>" />
			</p>
			<?php
		}



		function meta_box_evento_video($post) {
			wp_nonce_field( basename( __FILE__ ), 'meta_box_evento_video-nonce' );
			$video_type = get_post_meta($post->ID,'video-type',true); 
			if ($video_type == '') {
				$video_type = 'youtube';
			}
			$wp_video_url = get_post_meta($post->ID, 'wp-video-url', true);
			$yt_video_url = get_post_meta($post->ID, 'yt-video-url', true);
			?>
			<p><?php _e('Este será el vídeo que se muestre en la cabecera de la página de detalle del evento.','os_evento_type'); ?></p>
			<p><?php _e('Fuente: ','os_evento_type'); ?></p>
			<p>
				<input type="radio" name="video-type" id="video-type-yt" value="youtube" <?php if ( !empty ( $video_type ) ) { checked( $video_type, 'youtube' );} ?>>
				<label for="video-type-yt"><?php _e( 'Youtube', 'os_evento_type' )?></label>
			</p>
			<p>
				<input type="radio" name="video-type" id="video-type-wp" value="wordpress" <?php if ( !empty ( $video_type ) ) { checked( $video_type, 'wordpress' ); } ?>>
				<label for="video-type-wp"><?php _e( 'WordPress', 'os_evento_type' )?></label>
			</p>
			<p class="video-youtube" <?php if($video_type != 'youtube') { echo 'style="display: none;"'; } ?>>
				<label for="yt-video-url"><?php _e('Enlace a un vídeo de Youtube', 'os_evento_type'); ?></label>
				<input class="widefat" id="yt-video-url" name="yt-video-url" type="text" value="<?php if (isset($yt_video_url)) echo $yt_video_url; ?>"/>
			</p>
			<p class="video-wordpress" <?php if($video_type != 'wordpress') { echo 'style="display: none;"'; } ?>>
				<label for="wp-video-url"><?php _e('URL de un vídeo alojado en WordPress', 'os_evento_type'); ?></label>
				<input class="widefat" id="wp-video-url" name="wp-video-url" type="text" value="<?php if (isset($wp_video_url)) echo $wp_video_url; ?>" readonly="readonly"/>
			</p>    
			<p class="video-wordpress" <?php if($video_type != 'wordpress') { echo 'style="display: none;"'; } ?>>
				<input id="upload_evento_videoEvento" name="upload_evento_videoEvento" type="button" value="<?php _e('Explorar/Subir', 'os_evento_type'); ?>" />
			</p>
		  <?php 
		}


		function meta_box_evento_documento($post) {
			wp_nonce_field( basename( __FILE__ ), 'meta_box_evento_documento-nonce');
			$evento_documento = get_post_meta($post->ID, 'evento_documento', true); 
			?>
			<p><?php _e('Este es el enlace al documento que se muestra en la página de detalle del evento.','os_evento_type'); ?></p>
			<p>
				<label for="evento_documento"><?php _e('URL de un documento alojado en WordPress', 'os_evento_type'); ?></label>
				<input class="widefat" id="evento_documento" name="evento_documento" type="text" value="<?php if (!empty($evento_documento)) echo $evento_documento; ?>" readonly="readonly"/>
			</p>
			<p>
				<input id="upload_evento_documento" name="upload_evento_documento" type="button" value="<?php _e('Explorar/Subir', 'os_evento_type'); ?>" />
			</p>
			<?php
		}


		function meta_box_evento_fecha($post) {
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_fecha-nonce');
			$evento_fecha_de_inicio = get_post_meta($post->ID, 'evento_fecha_de_inicio', true);
			$evento_fecha_de_final = get_post_meta($post->ID, 'evento_fecha_de_final', true);
			?>
			<p><?php _e('Este es el rango de fechas de cuándo tendrá lugar el evento.', 'os_evento_type'); ?></p>
			<p>
				<label class="classfat" for="evento_fecha_de_inicio"><?php _e('Fecha de inicio', 'os_evento_type'); ?></label>
				<input type="date" id="evento_fecha_de_inicio" name="evento_fecha_de_inicio" class="widefat" value="<?php echo $evento_fecha_de_inicio; ?>">
				<span class="description">(<?php _e('Formato: DD/MM/AAAA', 'os_evento_type'); ?>)</span>
			</p>
			<p>
				<label class="classfat" for="evento_fecha_de_final"><?php _e('Fecha de final', 'os_evento_type'); ?></label>
				<input type="date" id="evento_fecha_de_final" name="evento_fecha_de_final" class="widefat" value="<?php echo $evento_fecha_de_final; ?>">
				<span class="description">(<?php _e('Formato: DD/MM/AAAA', 'os_evento_type'); ?>)</span>
			</p>

			<?php
		}


		function meta_box_evento_localizacion($post) {
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_localizacion-nonce');
			$evento_localizacion = get_post_meta($post->ID, 'evento_localizacion', true);
			?>
			<p><?php _e('Esta es la localización del evento. Los campos de título y dirección se mostrarán de manera informativa en los widgets y páginas de detalle de eventos.', 'os_evento_type'); ?></p>
			<p><?php _e('Para colocar el tooltip del mapa en la página de detalle de evento futuro se utilizarán los campos de latitud, longitud y altitud.', 'os_evento_type'); ?></p>
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
				<label class="classfat" for="evento_localizacion[2]"><?php _e('Latitud', 'os_evento_type'); ?></label>
				<input type="number" step="any" id="evento_localizacion[2]" name="evento_localizacion[2]" class="widefat" placeholder="<?php _e('Latitud', 'os_evento_type'); ?>" value="<?php echo $evento_localizacion[2]; ?>">
				<span class="description">(<?php _e('Por ejemplo: -34.397', 'os_evento_type'); ?>)</span>
			</p>
			<p>
				<label class="classfat" for="evento_localizacion[3]"><?php _e('Longitud', 'os_evento_type'); ?></label>
				<input type="number" step="any" id="evento_localizacion[3]" name="evento_localizacion[3]" class="widefat" placeholder="<?php _e('Longitud', 'os_evento_type'); ?>" value="<?php echo $evento_localizacion[3]; ?>">
				<span class="description">(<?php _e('Por ejemplo: 150.644', 'os_evento_type'); ?>)</span>
			</p>
			<p>
				<label class="classfat" for="evento_localizacion[4]"><?php _e('Altitud', 'os_evento_type'); ?></label>
				<input type="number" step="any" id="evento_localizacion[4]" name="evento_localizacion[4]" class="widefat" placeholder="<?php _e('Altitud', 'os_evento_type'); ?>" value="<?php echo $evento_localizacion[4]; ?>">
				<span class="description">(<?php _e('Por ejemplo: 0.8', 'os_evento_type'); ?>)</span>
			</p>
			<?php   
		}


		function meta_box_evento_descripcion_corta($post) {
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_descripcion_corta-nonce');
			$evento_descripcion_corta = get_post_meta($post->ID, 'evento_descripcion_corta', true);
			?>
			<p><?php _e('Este es el texto introductorio que aparecerá en la tarjeta que muestra el resumen del evento.', 'os_evento_type'); ?></p>
			<label class="screen-reader-text" for="evento_descripcion_corta"><?php _e('Descripción corta del evento', 'os_evento_type'); ?></label>
			<textarea rows="1" cols="40" maxlength="280" name="evento_descripcion_corta" id="evento_descripcion_corta"><?php echo $evento_descripcion_corta; ?></textarea>
			<span class="description">(<?php _e('Máx. 300 carácteres', 'os_evento_type'); ?>)</span>
			<?php   
		}


		function meta_box_evento_descripcion_larga($post) {
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_descripcion_larga-nonce');
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
			?>
			<p><?php _e('Este es el texto descriptivo que aparecerá en la página de detalle del evento.', 'os_evento_type'); ?></p>
			<?php
			wp_editor($evento_descripcion_larga, 'eventodescripcionlarga', $settings);
		}


		function meta_box_evento_topics($post) {
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_topics-nonce');
			$evento_topics = get_post_meta($post->ID, 'evento_topics', true);
			?>
			<p><?php _e('Estos son los topics del evento.', 'os_evento_type'); ?></p>
			<input type="text" id="evento_topics[0]" name="evento_topics[0]" class="widefat" placeholder="<?php _e('Topic 1', 'os_evento_type'); ?>" value="<?php echo $evento_topics[0]; ?>">
			<input type="text" id="evento_topics[1]" name="evento_topics[1]" class="widefat" placeholder="<?php _e('Topic 2', 'os_evento_type'); ?>" value="<?php echo $evento_topics[1]; ?>">
			<input type="text" id="evento_topics[2]" name="evento_topics[2]" class="widefat" placeholder="<?php _e('Topic 3', 'os_evento_type'); ?>" value="<?php echo $evento_topics[2]; ?>">
			<?php 	
		}


		function meta_box_evento_highlights($post) {
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_highlights-nonce');
			$evento_highlights = get_post_meta($post->ID, 'evento_highlights', true);
			?>
			<p><?php _e('Estos son los highlights del evento.', 'os_evento_type'); ?></p>
			<input type="text" id="evento_highlights[0]" name="evento_highlights[0]" class="widefat" placeholder="<?php _e('Highlight 1', 'os_evento_type'); ?>" value="<?php echo $evento_highlights[0]; ?>">
			<input type="text" id="evento_highlights[1]" name="evento_highlights[1]" class="widefat" placeholder="<?php _e('Highlight 2', 'os_evento_type'); ?>" value="<?php echo $evento_highlights[1]; ?>">
			<input type="text" id="evento_highlights[2]" name="evento_highlights[2]" class="widefat" placeholder="<?php _e('Highlight 3', 'os_evento_type'); ?>" value="<?php echo $evento_highlights[2]; ?>">
			<?php 	
		}


		function meta_box_evento_te_interesa($post) {
			wp_nonce_field(basename(__FILE__), 'meta_box_evento_te_interesa-nonce');
			$evento_te_interesa = get_post_meta($post->ID, 'evento_te_interesa', true);
			?>
			<p><?php _e('Estos son los tres temas que puedan resultar intersantes del evento.', 'os_evento_type'); ?></p>
			<input type="text" id="evento_te_interesa[0]" name="evento_te_interesa[0]" class="widefat" placeholder="<?php _e('Te interesa 1', 'os_evento_type'); ?>" value="<?php echo $evento_te_interesa[0]; ?>">
			<input type="text" id="evento_te_interesa[1]" name="evento_te_interesa[1]" class="widefat" placeholder="<?php _e('Te interesa 2', 'os_evento_type'); ?>" value="<?php echo $evento_te_interesa[1]; ?>">
			<input type="text" id="evento_te_interesa[2]" name="evento_te_interesa[2]" class="widefat" placeholder="<?php _e('Te interesa 3', 'os_evento_type'); ?>" value="<?php echo $evento_te_interesa[2]; ?>">
			<?php 	
		}


		function meta_boxes_save($post_id) {

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
				if($_POST['video-type'] == 'youtube') {
					if (isset($_POST['yt-video-url'])) {
						update_post_meta($post_id, 'yt-video-url', strip_tags($_POST['yt-video-url']));
					}
				} else if($_POST['video-type'] == 'wordpress') {
					if (isset($_POST['wp-video-url'])) {
						update_post_meta($post_id, 'wp-video-url', strip_tags($_POST['wp-video-url']));
					}
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
				for ($i = 2; $i < 5; $i++) { 
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
		
		}


    }

    $os_evento_type = new OS_Evento_Type();

}
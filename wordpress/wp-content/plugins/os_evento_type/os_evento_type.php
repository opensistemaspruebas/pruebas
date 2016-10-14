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
                'taxonomies'            => array('topic'),
			);
			register_post_type($this->post_type, $args );
        }


        function register_admin_styles(){
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_style('os-evento-type-css', plugin_dir_url(__FILE__) . 'css/os_evento_type.css');               
            }
        }


        function add_custom_meta_boxes() {
		  add_meta_box('evento_descripcion_corta',  __('Descripción corta del evento', 'os_evento_type'), array(&$this, 'meta_box_evento_descripcion_corta'), 'evento', 'normal', 'high');
		  add_meta_box('evento_descripcion_larga',  __('Descripción larga del evento', 'os_evento_type'), array(&$this, 'meta_box_evento_descripcion_larga'), 'evento', 'normal', 'high');
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



		function meta_boxes_save($post_id) {
			if (isset($_POST['evento_descripcion_corta'])) {
				update_post_meta($post_id, 'evento_descripcion_corta', strip_tags($_POST['evento_descripcion_corta']));
			}
			if (isset($_POST['eventodescripcionlarga'])) {
				update_post_meta($post_id, 'evento_descripcion_larga', $_POST['eventodescripcionlarga']);
			}
		}


    }

    $os_evento_type = new OS_Evento_Type();

}
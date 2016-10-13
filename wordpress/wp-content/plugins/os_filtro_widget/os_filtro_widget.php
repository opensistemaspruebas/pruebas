<?php

/*
	Plugin Name: OS Filtro Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que busca publicaciones y filtra por etiquetas.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_filtro_widget
*/


if (!class_exists('OS_Filtro_Widget')) :

	class OS_Filtro_Widget extends WP_Widget {


		function __construct() {
	        $options = array(
	            'classname' => "os_filtro_widget",
	            'description' => __('Widget que busca publicaciones y filtra por etiquetas', 'os_filtro_widget')
	        );
	        $this->WP_Widget('os_filtro_widget', __('OS Filtro Widget', 'os_filtro_widget'), $options);
	        add_action('plugins_loaded', array(&$this, 'load_text_domain'), 10);
	        add_action('wp_enqueue_scripts', array(&$this, 'add_script_filter_widget'));
	    }


	    // Selecciona el dominio para la traducción
        public function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_filtro_widget', false, $plugin_dir . "/languages");
        }


	    public function widget($args, $instance) {

	    	echo $args['before_widget'];

	    	$categories = get_terms(
				array(
					"taxonomy" => array("category"),
					"hide_empty" => false,
					"fields" => "all"
				)
			);

			$authors = get_users(
				array(
					'fields' => array(
						'display_name'
					),
					'who' => 'authors'
				)
			);

	    	$countries = get_terms(
				array(
					"taxonomy" => array("ambito_geografico"),
					"hide_empty" => false,
					"fields" => "all"
				)
			);

			
	    	$orden = 'DESC';

			?>
			<div class="visible-xs mobile-filter filter-mobile-button">
				<a href="#"><span class="bbva-icon-filter"></span> <?php _e('filtrar', 'os_filtro_widget'); ?></a>
			</div>
			<div class="sort-items-container">
				<a data-order="DESC" class="<?php if ($orden == 'DESC') echo 'selected';?>" href="#">
					<span class="icon bbva-icon-arrow arrow arrowUp"></span>
					<span class="text"><?php _e('Más recientes', 'os_filtro_widget'); ?></span>
				</a>
				<a data-order="ASC" class="<?php if ($orden == 'ASC') echo 'selected';?>" href="#">
					<span class="icon bbva-icon-arrow arrow arrowDown"></span>
					<span class="text"><?php _e('Más antiguos', 'os_filtro_widget'); ?></span>
				</a>
				<a data-order="DESTACADOS" class="<?php if ($orden == 'DESTACADOS') echo 'selected';?>" href="#">
					<span class="icon bbva-icon-view"></span>
					<span class="text"><?php _e('Más leídos', 'os_filtro_widget'); ?></span>
				</a>
			</div>
			<a class="filter show-publishing-filter hidden-xs" href="#" data-toggle="modal" data-target=".publishing-filter-modal"> <span class="bbva-icon-filter"></span> <span><?php _e('Filtrar', 'os_filtro_widget'); ?></span> </a>
			<?php

	    }


	    public function form($instance) {
	        ?>
	        <p><?php _e('Este widget no tiene parámetros configurables.', 'os_filtro_widget'); ?></p>
	        <?php
	    }


	    function update($new_instance, $old_instance) {
	    	return $new_instance;
	    }


		function add_script_filter_widget() {
            if (is_active_widget(false, false, $this->id_base, true)) {
		        wp_register_script('os_filtro_widget_js', plugins_url('js/os_filtro_widget.js' , __FILE__), array('jquery'));
		        $translation_array = array(
		        	'more_results' => __('Más resultados', 'os_filtro_widget'),
		        	'no_results' => __('Sin resultados', 'os_filtro_widget'),
		        	'sort_by_asc_date' => __('Más antiguos', 'os_filtro_widget'),
		        	'sort_by_desc_date' => __('Más recientes', 'os_filtro_widget'),
		        	'sort_by_popular' => __('Más leídos', 'os_filtro_widget'),
		      	);
		        wp_localize_script('os_filtro_widget_js', 'object_name', $translation_array );
	            wp_enqueue_script('os_filtro_widget_js');
            }
        } 


	}

	add_action('widgets_init', create_function('', 'return register_widget("os_filtro_widget");'));


endif;
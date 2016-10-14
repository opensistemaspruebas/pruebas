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

			
			?>
			<form action="#" method="get" name="form_filter" id="form_filter">
				<label for="inputText" class="assistive-text hidden"><?php _e('Texto', 'os_filtro_widget'); ?></label>
				<input type="text" class="field" name="inputText" id="inputText">
				<div id="caja_seleccion">
					<ul id="seleccion" name="seleccion"></ul>
				</div>
				<input type="submit" name="submitButton" id="submitButton" value="<?php _e('Buscar', 'os_filtro_widget'); ?>">
				<input type="hidden" name="topic" id="topic" value="publicacion">
				<input type="hidden" name="size" id="size" value="7">
				<input type="hidden" name="start" id="start" value="0">
				<input type="hidden" name="inputSortBy" id="inputSortBy" value="date desc">
				<div id="caja_categorias" id="caja_categorias" style="display: none;">
					<h2><?php _e('Categorías', 'os_filtro_widget'); ?> <span class="num">(<?php echo wp_count_terms("category"); ?>)</span></h2>
					<?php if (!empty($categories)) : ?>
					<ul id="categorias" name="categorias">
						<?php foreach ($categories as $category) : ?>
							<li class="categoria" term-id="<?php echo $category->term_id; ?>" style="display: none;"><a href="#"><?php echo $category->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>

				<div id="caja_autores" id="caja_autores" style="display: none;">
					<h2><?php _e('Autores', 'os_filtro_widget'); ?> <span class="num">(<?php echo count($authors); ?>)</span></h2>
					<?php if (!empty($authors)) : ?>
					<ul id="autores" name="autores">
						<?php foreach ($authors as $author) : ?>
							<li class="autor" term-id="<?php echo $author->display_name; ?>" style="display: none;"><a href="#"><?php echo $author->display_name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
				<div id="caja_paises" id="caja_paises" style="display: none;">
					<h2><?php _e('Ámbito geográfico', 'os_filtro_widget'); ?> <span class="num">(<?php echo wp_count_terms("ambito_geografico"); ?>)</span></h2>
					<?php if (!empty($countries)) : ?>
					<ul id="paises" name="paises">
						<?php foreach ($countries as $country) : ?>
							<li class="pais" term-id="<?php echo $country->term_id; ?>"><a href="#"><?php echo $country->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
			</form>
			<div id="sortLinks"></div>
			<div id="results"></div>			
			<div id="moreLink"></div>
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
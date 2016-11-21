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
	    }


        public function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_filtro_widget', false, $plugin_dir . "/languages");
        }


	    public function widget($args, $instance) {

	    	$this->is_active = true; 
	    	$this->add_script_filter_widget();
	    	imprimir_json_etiquetas();

			?>
			<input type="hidden" name="start" id="start" value="0">
			<input type="hidden" name="sortBy" id="sortBy" value="date desc">
			<a class="filter show-publishing-filter hidden-xs" href="#" data-toggle="modal" data-target=".publishing-filter-modal"><span class="bbva-icon-filter"></span><span><?php _e('Filtrar', 'os_filtro_widget'); ?></span></a>
			<div class="options-filter">
			    <div id="publishing-filter" class="content publishing-filter-wrapper hidden filter-container">
			        <div class="form-wrapper">
			            <div class="title"><span class="text-uppercase text"><?php _e('filtros', 'os_filtro_widget'); ?></span>
			                <button type="button" class="close close-publishing-filter btn-close"><span class="icon bbva-icon-close"></span></button>
			            </div>
			            <div class="search">
			                <input class="publishing-filter-search-input" type="text" name="publishing-filter-search-input" value="">
			                <button class="btn-bbva-aqua publishing-filter-search-btn" type="button" name="publishing-filter-search-btn"><?php _e('Buscar', 'os_filtro_widget'); ?></button>
			            </div>
			            <div class="selected-tags-container"></div>
			        </div>
			        <section>
			            <div class="row available-tags-wrapper">
			                <div class="col-xs-4">
			                    <p class="text-uppercase column-name"><?php _e('etiquetas', 'os_filtro_widget'); ?> (<span class="tag-container-counter">0</span>)</p>
			                    <div class="tag-container"></div>
			                </div>
			                <div class="col-xs-4">
			                    <p class="text-uppercase column-name"><?php _e('Autores', 'os_filtro_widget'); ?> (<span class="author-container-counter">0</span>)</p>
			                    <div class="author-container"></div>
			                </div>
			                <div class="col-xs-4">
			                    <p class="text-uppercase column-name"><?php _e('ámbito geográfico', 'os_filtro_widget'); ?> (<span class="geo-container-counter">0</span>)</p>
			                    <div class="geo-container"></div>
			                </div>
			            </div>
			        </section>
			    </div>
			</div>
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
            if (is_active_widget(false, $this->id, $this->id_base, true) || $this->is_active) {
		        wp_register_script('os_filtro_widget_js', plugins_url('js/os_filtro_widget.js' , __FILE__), array('jquery'));
		        $translation_array = array(
		        	'more_results' => __('Más resultados', 'os_filtro_widget'),
		        	'no_results' => __('Sin resultados', 'os_filtro_widget'),
		        	'sort_by_asc_date' => __('Más antiguos', 'os_filtro_widget'),
		        	'sort_by_desc_date' => __('Más recientes', 'os_filtro_widget'),
		        	'sort_by_popular' => __('Destacados', 'os_filtro_widget'),
		        	'resultado_de_busqueda' => __('Resultado de la búsqueda', 'os_filtro_widget'),
		        	'lang' => str_replace('_', '-', get_locale()),
		      	);
		        wp_localize_script('os_filtro_widget_js', 'object_name', $translation_array );
	            wp_enqueue_script('os_filtro_widget_js');
	            add_action('wp_footer', array($this, 'dequeue_redundant_scripts'), 1);
            }
        }


        function dequeue_redundant_scripts() {
		    if (!$this->is_active) {
		        wp_dequeue_script('os_filtro_widget_js');
		    }
		}

	}

	add_action('widgets_init', create_function('', 'return register_widget("os_filtro_widget");'));


endif;
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
	    	$this->imprimir_json_etiquetas();

			?>
			<!--<form action="#" method="get" name="form_filter" id="form_filter">
				<label for="inputText" class="assistive-text hidden"><?php //_e('Texto', 'os_filtro_widget'); ?></label>
				<input type="text" class="field" name="inputText" id="inputText">
				<div id="caja_seleccion">
					<ul id="seleccion" name="seleccion"></ul>
				</div>
				<input type="submit" name="submitButton" id="submitButton" value="<?php //_e('Buscar', 'os_filtro_widget'); ?>">
				<input type="hidden" name="topic" id="topic" value="publicacion">
				<input type="hidden" name="size" id="size" value="7">
				<input type="hidden" name="start" id="start" value="0">
				<input type="hidden" name="inputSortBy" id="inputSortBy" value="date desc">
				<div id="caja_categorias" id="caja_categorias" style="display: none;">
					<h2><?php //_e('Categorías', 'os_filtro_widget'); ?> <span class="num">(<?php //echo wp_count_terms("category"); ?>)</span></h2>
					<?php //if (!empty($categories)) : ?>
					<ul id="categorias" name="categorias">
						<?php //foreach ($categories as $category) : ?>
							<li class="categoria" term-id="<?php //echo $category->term_id; ?>" style="display: none;"><a href="#"><?php //echo $category->name; ?></a></li>
						<?php //endforeach; ?>
					</ul>
					<?php //endif; ?>
				</div>

				<div id="caja_autores" id="caja_autores" style="display: none;">
					<h2><?php //_e('Autores', 'os_filtro_widget'); ?> <span class="num">(<?php //echo count($authors); ?>)</span></h2>
					<?php //if (!empty($authors)) : ?>
					<ul id="autores" name="autores">
						<?php //foreach ($authors as $author) : ?>
							<li class="autor" term-id="<?php //echo $author->display_name; ?>" style="display: none;"><a href="#"><?php //echo $author->display_name; ?></a></li>
						<?php //endforeach; ?>
					</ul>
					<?php //endif; ?>
				</div>
				<div id="caja_paises" id="caja_paises" style="display: none;">
					<h2><?php //_e('Ámbito geográfico', 'os_filtro_widget'); ?> <span class="num">(<?php //echo wp_count_terms("ambito_geografico"); ?>)</span></h2>
					<?php //if (!empty($countries)) : ?>
					<ul id="paises" name="paises">
						<?php //foreach ($countries as $country) : ?>
							<li class="pais" term-id="<?php //echo $country->term_id; ?>"><a href="#"><?php// echo $country->name; ?></a></li>
						<?php //endforeach; ?>
					</ul>
					<?php //endif; ?>
				</div>
			</form>
			<div id="sortLinks"></div>
			<div id="results"></div>			
			<div id="moreLink"></div>-->
			<input type="hidden" name="start" id="start" value="0">
			<input type="hidden" name="inputSortBy" id="inputSortBy" value="date desc">
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
			                    <p class="text-uppercase column-name"><?php _e('tags', 'os_filtro_widget'); ?> (<span class="tag-container-counter">0</span>)</p>
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
		        	'sort_by_popular' => __('Más leídos', 'os_filtro_widget'),
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


        function imprimir_json_etiquetas() {
	    	$categories = get_terms(
				array(
					"taxonomy" => array("category"),
					"hide_empty" => false,
					"fields" => "id=>name"
				)
			);
	    	$args_autores = 
			$autores = get_posts(
				array(
					'posts_per_page'   => -1,
					'offset'           => 0,
					'orderby'          => 'post_title',
					'order'            => 'ASC',
					'post_type'        => 'guest-author',
					'post_status'      => 'publish',
					'suppress_filters' => true,
					'tax_query' => array(
				        array(
				            'taxonomy' => 'perfil',
				            'field'    => 'slug',
				            'terms'    => 'autor'
				        )
				    )
				)
			);
    		$author_names = array();
    		if (!empty($autores)) {
    			foreach ($autores as $autor) {
					$name = $autor->post_title;
					array_push($author_names, $name);
    			}
    		}
    		$autores = get_users(
    			array(
    				'who' => 'authors',
    			)
    		);
    		if (!empty($autores)) {
    			foreach ($autores as $autor) {
					$name = $autor->data->display_name;
					array_push($author_names, $name);
    			}
    		}
	    	$countries = get_terms(
				array(
					"taxonomy" => array("ambito_geografico"),
					"hide_empty" => false,
					"fields" => "id=>name"
				)
			);
	    	$id = 1;
	    	$data = array();
	    	if (!empty($categories)) {
	    		foreach ($categories as $key => $category) {
	    			$tag = array();
	    			$tag['text'] = $category;
	    			$tag['deleteButton'] = false;
	    			$tag['class'] = 'available-tag';
	    			$tag['from'] = 'tag-container';
	    			$tag['id'] = 'tag-' . $key;
	    			array_push($data, $tag);
	    			$id++;
	    		}
	    	}
	    	if (!empty($author_names)) {
	    		foreach ($author_names as $author_name) {
	    			$tag = array();
	    			$tag['text'] = $author_name;
	    			$tag['deleteButton'] = false;
	    			$tag['class'] = 'available-tag';
	    			$tag['from'] = 'author-container';
	    			$tag['id'] = 'tag-' . $id;
	    			array_push($data, $tag);
	    			$id++;
	    		}	
	    	}
	    	if (!empty($countries)) {
	    		foreach ($countries as $key => $country) {
	    			$tag['text'] = $country;
	    			$tag['deleteButton'] = false;
	    			$tag['class'] = 'available-tag';
	    			$tag['from'] = 'geo-container';
	    			$tag['id'] = 'tag-' . $key;
	    			array_push($data, $tag);
	    			$id++;
	    		}
	    	}
	    	echo "<script>var data = {'availableTags':" . json_encode($data) . "};</script>";
        }


	}

	add_action('widgets_init', create_function('', 'return register_widget("os_filtro_widget");'));


endif;
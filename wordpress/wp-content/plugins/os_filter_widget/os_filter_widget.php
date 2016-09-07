<?php

/*
	Plugin Name: OS Filter Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que busca publicaciones y filtra por etiquetas.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_filter_widget
*/


if (!class_exists('OS_Filter_Widget')) :

	class OS_Filter_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_filter_widget',
	        	__('OS Filter Widget', 'os_filter_widget'),
	        	array(
	            	'description' => __('Widget que busca publicaciones y filtra por etiquetas', 'os_filter_widget')
	        	)
	        );
	        wp_register_script('os_filter_widget_js', plugins_url('js/os_filter_widget.js' , __FILE__), array('jquery'));
            wp_enqueue_script('os_filter_widget_js');
	    }


	    public function widget($args, $instance) {

	    	echo $args['before_widget'];

	    	$categorias = get_terms('category', array('hide_empty' => false));
	    	$categorias_listado = '';
	    	foreach ($categorias as $categoria) {
	    		if (!empty($categorias_listado)) {
	    			$categorias_listado .= ',';
	    		}
	    		$categorias_listado .= $categoria->name;
	    	}


	    	$autores = get_users(array('role' => 'author'));
	    	$autores_listado = '';
	    	foreach ($autores as $autor) {
	    		if (!empty($autores_listado)) {
	    			$autores_listado .= ',';
	    		}
	    		$autores_listado .= $autor->display_name;
	    	}

	    	$paises = get_terms('country', array('hide_empty' => false));
	    	$paises_listado = '';
	    	foreach ($paises as $pais) {
	    		if (!empty($paises_listado)) {
	    			$paises_listado .= ',';
	    		}
	    		$paises_listado .= $pais->name;
	    	}

			?>
			<h1><?php _e('Filters', 'os_filter_widget'); ?></h1>
			<form action="#" method="get" name="form_filter" id="form_filter">
				
				<label for="inputText" class="assistive-text"><?php _e('Text', 'os_filter_widget'); ?></label>
				<input type="text" class="field" name="inputText" id="inputText">
				
				<label for="inputCategory" class="assistive-text"><?php _e('Category', 'os_filter_widget'); ?></label>
				<input type="text" class="field" name="inputCategory" id="inputCategory">
				
				<label for="inputAuthor" class="assistive-text"><?php _e('Author', 'os_filter_widget'); ?></label>
				<input type="text" class="field" name="inputAuthor" id="inputAuthor">
				
				<label for="inputGeography" class="assistive-text"><?php _e('Geography', 'os_filter_widget'); ?></label>
				<input type="text" class="field" name="inputGeography" id="inputGeography">
				
				<input type="submit" name="submitButton" id="submitButton" value="<?php _e('Search', 'os_filter_widget'); ?>">
			</form>
			<div id="results"></div>
			<?php

			/*echo '<h2>' . __("Categories", "os_filter_widget") . '</h2>';
			echo '<ul>';
			foreach ($categorias as $categoria) {
				echo '<li><a href="#" name="' . $categoria->slug . ' id="' . $categoria->slug . '">' . $categoria->name . '</a></li>';
			}
			echo '</ul>';

			echo '<h2>' . __("Authors", "os_filter_widget") . '</h2>';
			echo '<ul>';
			foreach ($autores as $autor) {
				echo '<li><a href="#" name="' . $autor->user_login . ' id="' . $autor->user_login . '">' . $autor->display_name . '</a></li>';
			}
			echo '</ul>';

			echo '<h2>' . __("Countries", "os_filter_widget") . '</h2>';
			echo '<ul>';
			foreach ($paises as $pais) {
				echo '<li><a href="#" name="' . $pais->slug . ' id="' . $pais->slug . '">' . $pais->name . '</a></li>';
			}
			echo '</ul>';*/

			echo $args['after_widget'];

	    }


	    public function form($instance) {
	        ?>
	        <p><?php _e('Este widget no tiene parámetros configurables.', 'os_filter_widget'); ?></p>
	        <?php
	    }


	    function update($new_instance, $old_instance) {
	    	return $new_instance;
	    }

	}

	function os_filter_widget() {
	    register_widget('os_filter_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_filter_widget');

endif;

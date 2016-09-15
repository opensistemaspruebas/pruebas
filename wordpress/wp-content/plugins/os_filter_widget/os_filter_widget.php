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
	        wp_register_script('os_filter_widget_js', plugins_url('js/os_filter_widget_min.js' , __FILE__), array('jquery'));
	        $translation_array = array(
				'no_results' => __('No results found', 'os_filter_widget'),
				'more_results' => __('More', 'os_filter_widget'),
				'sort_by_asc_date' => __('Older', 'os_filter_widget'),
				'sort_by_desc_date' => __('Recents', 'os_filter_widget'),
				'sort_by_popular' => __('Popular', 'os_filter_widget'),
				'ajaxurl' => admin_url('admin-ajax.php'),
				
			);
			wp_localize_script('os_filter_widget_js', 'object_name', $translation_array);
            wp_enqueue_script('os_filter_widget_js');
        }


	    public function widget($args, $instance) {

	    	echo $args['before_widget'];

	    	$categories = get_terms(
				array(
					"taxonomy" => array("post_tag", "category"),
					"hide_empty" => true,
					"fields" => "names"
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
					"hide_empty" => true,
					"fields" => "names"
				)
			);

			?>
			<?php 
				echo $args['before_title']; 
				_e('Filtros', 'os_filter_widget');
				echo $args['after_title']; 
			?>
			<form action="#" method="get" name="form_filter" id="form_filter">
				
				<label for="inputText" class="assistive-text"><?php _e('Texto', 'os_filter_widget'); ?></label>
				<input type="text" class="field" name="inputText" id="inputText">

				<input type="hidden" name="size" id="size" value="7">
				<input type="hidden" name="start" id="start" value="0">
				<input type="hidden" name="inputSortBy" id="inputSortBy" value="date desc">

				<label for="selectCategory" class="assistive-text"><?php _e('Categorías', 'os_filter_widget'); ?></label>
				<?php if (!empty($categories)) : ?>
				<select id="selectCategory" name="selectCategory" multiple="multiple">
					<?php foreach ($categories as $category) : ?>
						<option value="<?php echo $category; ?>"><?php echo $category; ?></option>
					<?php endforeach; ?>
				</select>
				<?php endif; ?>

				<label for="selectAuthor" class="assistive-text"><?php _e('Autores', 'os_filter_widget'); ?></label>
				<?php if (!empty($authors)) : ?>
				<select id="selectAuthor" name="selectAuthor" multiple="multiple">
					<?php foreach ($authors as $author) : ?>
						<option value="<?php echo $author->display_name; ?>"><?php echo $author->display_name; ?></option>
					<?php endforeach; ?>
				</select>
				<?php endif; ?>

				<label for="selectCountry" class="assistive-text"><?php _e('Ámbito geográfico', 'os_filter_widget'); ?></label>
				<?php if (!empty($countries)) : ?>
				<select id="selectCountry" name="selectCountry" multiple="multiple">
					<?php foreach ($countries as $country) : ?>
						<option value="<?php echo $country; ?>"><?php echo $country; ?></option>
					<?php endforeach; ?>
				</select>
				<?php endif; ?>
				
				<input type="submit" name="submitButton" id="submitButton" value="<?php _e('Buscar', 'os_filter_widget'); ?>">

			</form>
			
			<div id="sortLinks"></div>
			<div id="results"></div>			
			<div id="moreLink"></div>

			<?php

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
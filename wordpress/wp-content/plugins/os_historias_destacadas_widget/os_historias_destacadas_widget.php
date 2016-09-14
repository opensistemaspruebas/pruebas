<?php

/*
	Plugin Name: OS Historias Destacadas Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra las tres historias destacadas.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_historias_destacadas_widget
*/


if (!class_exists('OS_Historias_Destacadas_Widget')) :

	class OS_Historias_Destacadas_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_historias_destacadas_widget',
	        	__('OS Historias Destacadas', 'os_historias_destacadas_widget'),
	        	array(
	            	'description' => __('Muestra las tres historias destacadas.', 'os_historias_destacadas_widget')
	        	)
	        );
	       
	       	wp_register_script('os_historias_destacadas_widget_js', plugins_url('js/os_historias_destacadas_widget_min.js' , __FILE__), array('jquery'));
	        $translation_array = array(
				'only_3' => __('Solo puede seleccionar 3 historias', 'os_historias_destacadas_widget'),
			);
			wp_localize_script('os_historias_destacadas_widget_js', 'historias_destacadas', $translation_array);
            wp_enqueue_script('os_historias_destacadas_widget_js');

        }


	    public function widget($args, $instance) {
	    
	    	echo $args['before_widget'];

	    	$historia_destacada_1 = $instance['historia_destacada_1'];
	    	$historia_destacada_2 = $instance['historia_destacada_2'];
	    	$historia_destacada_3 = $instance['historia_destacada_3'];
	    	$url_historias = $instance['url_historias'];

	    	$post__in = array();
	    	if ($historia_destacada_1) {
	    		array_push($post__in, $historia_destacada_1);
	    	}
	    	if ($historia_destacada_2) {
	    		array_push($post__in, $historia_destacada_2);
	    	}
	    	if ($historia_destacada_3) {
	    		array_push($post__in, $historia_destacada_3);
	    	}

	    	if (!(empty($post__in))) {
	    		$historias = get_posts(
	    			array(
					    'include'   => $post__in,
					    'post_type' => 'historia',
					    'orderby'   => 'post__in',
					)
				);
	    	}


			?>

			<div class="wrapperContent">
			    <h2 class="section_titulo"><?php _e("Historias destacadas", "os_historias_destacadas_widget"); ?></h2>
			    <?php if (!empty($historias)) : ?>
			    <ul class="lista_noticias">
			    	<?php
			    		$i = 1;
			    		foreach ($historias as $p) {

			    			$post_content = strip_tags($p->post_content);
			    			if (!empty($post_content)) {
				    			$post_content = substr($post_content, 0, 80);
								$post_content = substr($post_content, 0, strrpos($post_content, ' ')) . "...";
							}

							echo '<li id="noticia_' . $i . '" class="col-md-4 col-sm-4 col-xs-12 ">
								    <figure class="contenidoNoticias_boxImage">' . get_the_post_thumbnail($p->ID, 'medium') . '</figure>
								    <div class="contenidoNoticias_boxTexto">
								        <p class="item_fecha">' . get_the_date('j F Y', $p->ID) . '</p>
								        <h3 class="item_titulo">' . $p->post_title . '</h3>
								        <p class="item_contenido">' . $post_content . '</p>
								        <a target="_blank" href="' . get_permalink($p->ID) . '">' . __("Leer más", "os_historias_destacadas_widget") . '</a>
								    </div>
								 </li>';
			    			$i++;
			    		}
			    	?>

			    </ul>
			    <p class="section_verTodos">
			        <a href="<?php echo $url_historias; ?>" class="icon-linkInterno">
			            <em><?php _e("Todas las historias", "os_historias_destacadas_widget"); ?></em>
			        </a>
			    </p>
			    <?php else : ?>
			    <p><?php _e("No hay historias disponibles.", "os_historias_destacadas_widget"); ?></p>
			    <?php endif; ?>
			</div>
	    	<?php

			echo $args['after_widget'];

	    }


	    public function form($instance) {
	    	
	    	$url_historias = ! empty($instance['url_historias']) ? $instance['url_historias'] : 'http://';
	    	$historia_destacada_1 = ! empty($instance['historia_destacada_1']) ? $instance['historia_destacada_1'] : '';
	    	$historia_destacada_2 = ! empty($instance['historia_destacada_2']) ? $instance['historia_destacada_2'] : '';
	    	$historia_destacada_3 = ! empty($instance['historia_destacada_3']) ? $instance['historia_destacada_3'] : '';
	    	
	    	$args = array(
				'posts_per_page'   => -1,
				'offset'           => 0,
				'category'         => '',
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'include'          => '',
				'exclude'          => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'post_type'        => 'historia',
				'post_mime_type'   => '',
				'post_parent'      => '',
				'post_status'      => 'publish',
				'suppress_filters' => true
			);
			$historias = get_posts($args);

	    	?>
	    	<p>
				<label for="<?php echo $this->get_field_id('url_historias'); ?>"><?php _e('URL de página de todas las historias:', 'os_historias_destacadas_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('url_historias'); ?>" name="<?php echo $this->get_field_name('url_historias'); ?>" type="url" value="<?php echo esc_attr($url_historias); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('historia_destacada_1'); ?>"><?php _e('Historia destacada 1:', 'os_historias_destacadas_widget'); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('historia_destacada_1'); ?>" name="<?php echo $this->get_field_name('historia_destacada_1'); ?>">
				  <?php if (!(empty($historias))) : ?>
				  <option value=""><?php _e('Ninguna', 'os_historias_destacadas_widget'); ?></option>
				  <?php foreach ($historias as $h) : ?>
				  <?php $selected = ($h->ID == $historia_destacada_1) ? 'selected="selected"' : ':'; ?>
				  <option value="<?php echo $h->ID; ?>" <?php echo $selected; ?>><?php echo $h->post_title; ?> | <?php echo $h->post_date; ?></option>
				  <?php endforeach; ?>
				  <?php else: ?>
				  <option value=""><?php _e('No hay historias disponibles', 'os_historias_destacadas_widget'); ?></option>
				  <?php endif; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('historia_destacada_2'); ?>"><?php _e('Historia destacada 2:', 'os_historias_destacadas_widget'); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('historia_destacada_2'); ?>" name="<?php echo $this->get_field_name('historia_destacada_2'); ?>">
				  <?php if (!(empty($historias))) : ?>
				  <option value=""><?php _e('Ninguna', 'os_historias_destacadas_widget'); ?></option>
				  <?php foreach ($historias as $h) : ?>
				  <?php $selected = ($h->ID == $historia_destacada_2) ? 'selected="selected"' : ':'; ?>
				  <option value="<?php echo $h->ID; ?>" <?php echo $selected; ?>><?php echo $h->post_title; ?> | <?php echo $h->post_date; ?></option>
				  <?php endforeach; ?>
				  <?php else: ?>
				  <option value=""><?php _e('No hay historias disponibles', 'os_historias_destacadas_widget'); ?></option>
				  <?php endif; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('historia_destacada_3'); ?>"><?php _e('Historia destacada 3:', 'os_historias_destacadas_widget'); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('historia_destacada_3'); ?>" name="<?php echo $this->get_field_name('historia_destacada_3'); ?>">
				  <?php if (!(empty($historias))) : ?>
				  <option value=""><?php _e('Ninguna', 'os_historias_destacadas_widget'); ?></option>
				  <?php foreach ($historias as $h) : ?>
				  <?php $selected = ($h->ID == $historia_destacada_3) ? 'selected="selected"' : ':'; ?>
				  <option value="<?php echo $h->ID; ?>" <?php echo $selected; ?>><?php echo $h->post_title; ?> | <?php echo $h->post_date; ?></option>
				  <?php endforeach; ?>
				  <?php else: ?>
				  <option value=""><?php _e('No hay historias disponibles', 'os_historias_destacadas_widget'); ?></option>
				  <?php endif; ?>
				</select>
			</p>

	    	<?php
	    }


	    function update($new_instance, $old_instance) {
	    	$instance = array();
	    	$instance['historia_destacada_1'] = (!empty( $new_instance['historia_destacada_1'])) ? strip_tags($new_instance['historia_destacada_1']) : '';
	    	$instance['historia_destacada_2'] = (!empty( $new_instance['historia_destacada_2'])) ? strip_tags($new_instance['historia_destacada_2']) : '';
	    	$instance['historia_destacada_3'] = (!empty( $new_instance['historia_destacada_3'])) ? strip_tags($new_instance['historia_destacada_3']) : '';
			$instance['url_historias'] = (!empty( $new_instance['url_historias'])) ? strip_tags($new_instance['url_historias']) : '';
			return $instance;
	    }

	}

	function os_historias_destacadas_widget() {
	    register_widget('os_historias_destacadas_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_historias_destacadas_widget');


endif;
<?php

/*
	Plugin Name: OS Impactos Home Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que los impactos en la home.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_impactos_home_widget
*/


if (!class_exists('OS_Impactos_Home_Widget')) :

	class OS_Impactos_Home_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_impactos_home_widget',
	        	__('OS Impactos Home Widget', 'os_impactos_home_widget'),
	        	array(
	            	'description' => __('Widget que los impactos en la home.', 'os_impactos_home_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {
	    	
	    	global $wpdb;

	    	/*echo '<pre>';
	    	print_r($instance);
	    	echo '</pre>';*/

	    	$title = $instance['title'];
	    	$texto = $instance['texto'];
	    	$impacto_1 = $instance['impacto_1'];
	    	$impacto_2 = $instance['impacto_2'];
	    	$impacto_3 = $instance['impacto_3'];
	    	$url_impactos = $instance['url_impactos'];

	    	?>
            <section class="pt-xl pb-lg">
                <div class="container">
                    <header class="title-description">
                        <h1><?php echo $title; ?></h1>
                        <div class="description-container">
                            <p><?php echo $texto; ?></p>
                        </div>
                    </header>
                    <div class="row circle-list">
			            <?php
			            	$query = new WP_Query(
			            		array(
			            			'post_type' => 'impacto', 
			            			'post__in' => array($impacto_1, $impacto_2, $impacto_3),
			            		)
			            	);

			            	if ($query->have_posts() ) {
								while ($query->have_posts()) : $query->the_post();
									$post_id = get_the_id();
									$visualizacion = (get_post_meta($post_id, 'visualizacion', true)) ? get_post_meta($post_id, 'visualizacion', true) : "circulo";
									$color = get_post_meta($post_id, 'color', true);
									$etiqueta = mb_strtoupper(get_post_meta($post_id, 'etiqueta', true), 'UTF-8');
									$objetivo = get_post_meta($post_id, 'objetivo', true);
									$completado = get_post_meta($post_id, 'completado', true);
									$titulo = get_post_meta($post_id, 'titulo', true);
									$subtitulo = get_post_meta($post_id, 'subtitulo', true);
									$animacion = get_post_meta($post_id, 'animacion', true);

									switch ($visualizacion) {
										case 'circulo':
											pintaCirculo($etiqueta, $color, $objetivo, $completado);
											break;
										case 'barra':
											pintaBarra($etiqueta, $color, $objetivo, $completado);
											break;
										case 'icono':
											pintaIcono();
											break;
									}
								endwhile;
								wp_reset_postdata();
							} else {
								_e("No hay impactos disponibles.", "os_impactos_home_widget");
							}

			            ?>
                    </div>
                    <div class="text-center">
                        <a href="<?php echo $url_impactos; ?>" class="btn btn-bbva-aqua"><?php _e("Ver impactos", "os_impactos_home_widget"); ?></a>
                    </div>
                </div>
            </section>
	    	<?php

	    }


	    public function form($instance) {
	    	
	    	$title = ! empty($instance['title']) ? $instance['title'] : '';
	    	$texto = ! empty($instance['texto']) ? $instance['texto'] : '';
	    	$url_impactos = ! empty($instance['url_impactos']) ? $instance['url_impactos'] : 'http://';
	    	$impacto_1 = ! empty($instance['impacto_1']) ? $instance['impacto_1'] : '';
	    	$impacto_2 = ! empty($instance['impacto_2']) ? $instance['impacto_2'] : '';
	    	$impacto_3 = ! empty($instance['impacto_3']) ? $instance['impacto_3'] : '';
	    	
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
				'post_type'        => 'impacto',
				'post_mime_type'   => '',
				'post_parent'      => '',
				'post_status'      => 'publish',
				'suppress_filters' => true
			);
			$impactos = get_posts($args);

	    	?>
	    	<p>
	    		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Título:', 'os_impactos_home_widget'); ?></label>
				<input required="required" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="url" value="<?php echo esc_attr($title); ?>">
			</p>
	    	<p>
	    		<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto:', 'os_impactos_home_widget'); ?></label>
				<textarea required="required" class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>"><?php echo $texto; ?></textarea>
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('url_impactos'); ?>"><?php _e('URL de página de todos los impactos:', 'os_impactos_home_widget'); ?></label>
				<input required="required" class="widefat" id="<?php echo $this->get_field_id('url_impactos'); ?>" name="<?php echo $this->get_field_name('url_impactos'); ?>" type="url" value="<?php echo esc_attr($url_impactos); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('impacto_1'); ?>"><?php _e('Impacto 1:', 'os_impactos_home_widget'); ?></label>
				<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_1'); ?>" name="<?php echo $this->get_field_name('impacto_1'); ?>">
				  <?php if (!(empty($impactos))) : ?>
				  <?php foreach ($impactos as $impacto) : ?>
				  <?php 
				  	$impacto_title = !(empty($impacto->post_title)) ? $impacto->post_title : __("Sin título", "os_impactos_home_widget");
				  ?>
				  <?php $selected = ($impacto->ID == $impacto_1) ? 'selected="selected"' : ':'; ?>
				  <option value="<?php echo $impacto->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
				  <?php endforeach; ?>
				  <?php else: ?>
				  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_home_widget'); ?></option>
				  <?php endif; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('impacto_2'); ?>"><?php _e('Impacto 2:', 'os_impactos_home_widget'); ?></label>
				<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_2'); ?>" name="<?php echo $this->get_field_name('impacto_2'); ?>">
				  <?php if (!(empty($impactos))) : ?>
				  <?php foreach ($impactos as $impacto) : ?>
				  <?php 
				  	$impacto_title = !(empty($impacto->post_title)) ? $impacto->post_title : __("Sin título", "os_impactos_home_widget");
				  ?>
				  <?php $selected = ($impacto->ID == $impacto_2) ? 'selected="selected"' : ':'; ?>
				  <option value="<?php echo $impacto->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
				  <?php endforeach; ?>
				  <?php else: ?>
				  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_home_widget'); ?></option>
				  <?php endif; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('impacto_3'); ?>"><?php _e('Impacto 3:', 'os_impactos_home_widget'); ?></label>
				<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_3'); ?>" name="<?php echo $this->get_field_name('impacto_3'); ?>">
				  <?php if (!(empty($impactos))) : ?>
				  <?php foreach ($impactos as $impacto) : ?>
				  <?php 
				  	$impacto_title = !(empty($impacto->post_title)) ? $impacto->post_title : __("Sin título", "os_impactos_home_widget");
				  ?>
				  <?php $selected = ($impacto->ID == $impacto_3) ? 'selected="selected"' : ':'; ?>
				  <option value="<?php echo $impacto->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
				  <?php endforeach; ?>
				  <?php else: ?>
				  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_home_widget'); ?></option>
				  <?php endif; ?>
				</select>
			</p>

	    	<?php
	    }


	    function update($new_instance, $old_instance) {
	    	$instance = array();
	    	$instance['title'] = (!empty( $new_instance['title'])) ? strip_tags($new_instance['title']) : '';
	    	$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : '';
	    	$instance['impacto_1'] = (!empty( $new_instance['impacto_1'])) ? strip_tags($new_instance['impacto_1']) : '';
	    	$instance['impacto_2'] = (!empty( $new_instance['impacto_2'])) ? strip_tags($new_instance['impacto_2']) : '';
	    	$instance['impacto_3'] = (!empty( $new_instance['impacto_3'])) ? strip_tags($new_instance['impacto_3']) : '';
			$instance['url_impactos'] = (!empty( $new_instance['url_impactos'])) ? strip_tags($new_instance['url_impactos']) : '';
			return $instance;
	    }

	}

	function os_impactos_home_widget() {
	    register_widget('os_impactos_home_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_impactos_home_widget');


endif;



function pintaCirculo($etiqueta, $color, $objetivo, $completado) {

	$porcentaje = $completado / $objetivo;

	switch ($color) {
		case '#14afb0':
			$colorClass = 'teel';
			break;
		case '#5bbeff':
			$colorClass = 'blue';
			break;
		case '#f8cd51':
			$colorClass = 'yellow';
			break;		
		default:
			$colorClass = 'blue';
			break;
	}($color);

	?>
	<div class="col-xs-12 col-sm-4 text-center">
		<div class="circle-container <?php echo $colorClass; ?> hidden-xs hidden-sm">
		    <div class="circle-progress">
		        <div class="circle-text">
		            <p class="circle-value"><?php echo thousandsCurrencyFormatCustom($completado); ?></p>
		            <p class="circle-label"><?php echo $etiqueta; ?></p>
		        </div>
		        <div class="procircle" data-value="<?php echo $porcentaje; ?>" data-size="260"></div>
		    </div>
		    <p class="circle-footer"><?php _e("Objetivo", "os_impacto_type"); ?> <?php echo thousandsCurrencyFormat($objetivo); ?></p>
		</div>
		<div class="circle-container <?php echo $colorClass; ?> hidden-md hidden-lg">
		    <div class="circle-progress">
		        <div class="circle-text">
		            <p class="circle-value"><?php echo thousandsCurrencyFormatCustom($completado); ?></p>
		            <p class="circle-label"><?php echo $etiqueta; ?></p>
		        </div>
		        <div class="procircle blue" data-value="<?php echo $porcentaje; ?>" data-size="190"></div>
		    </div>
		    <p class="circle-footer"><?php _e("Objetivo", "os_impacto_type"); ?> <?php echo thousandsCurrencyFormat($objetivo); ?></p>
		</div>
	</div>
	<?php
}

function pintaBarra() {

}

function pintaIcono() {
}
<?php

/*
	Plugin Name: OS Cards Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra tarjetas para distintos tipos de posts.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_cards_widget
*/


if (!class_exists('OS_Cards_Widget')) :

	class OS_Cards_Widget extends WP_Widget {

		// Constructor
	    function __construct() {
	        parent::__construct(
	        	'os_cards_widget',
	        	__('OS Cards Widget', 'os_cards_widget'),
	        	array(
	            	'description' => __('Muestra tarjetas para distintos tipos de posts.', 'os_cards_widget')
	        	)
	        );
        }

	    public function widget($args, $instance) {

	    	print_r($instance);

	    	$args = array(
			   'public'   => true,
			   '_builtin' => false
			);

			$output = 'names'; // names or objects, note names is the default
			$operator = 'and'; // 'and' or 'or'

	    	foreach (get_post_types( $args, $output, $operator ) as $post_type ) {
			   print_r($post_type);
			}

	    }


	    // Formulario del front-end
	    public function form($instance) {
	    	
	    	$titulo = (!empty($instance['titulo'])) ? $instance['titulo'] : '';
	    	$texto = (!empty($instance['texto'])) ? $instance['texto'] : '';
	    	$numero_posts_totales = (!empty($instance['numero_posts_totales'])) ? $instance['numero_posts_totales'] : 0;
	    	$numero_posts_mostrar = (!empty($instance['numero_posts_mostrar'])) ? $instance['numero_posts_mostrar'] : 0;
	    	$plantilla = (!empty($instance['plantilla'])) ? $instance['plantilla'] : '';
	    	$tipo_post = (!empty($instance['tipo_post'])) ? $instance['tipo_post'] : '';
	    	$enlace_detalle = (!empty($instance['enlace_detalle'])) ? $instance['enlace_detalle'] : '';
	    	$filtrar_por_autor = isset($instance[ 'filtrar_por_autor' ]) ? $instance['filtrar_por_autor'] : 'off';
	    	
	    	?>	
	    	<p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título', 'os_cards_widget'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto', 'os_cards_widget'); ?>:</label>
				<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>" type="text"><?php echo esc_attr($texto); ?></textarea>
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('numero_posts_totales'); ?>"><?php _e('Número de posts totales', 'os_cards_widget'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('numero_posts_totales'); ?>" name="<?php echo $this->get_field_name('numero_posts_totales'); ?>" type="number" value="<?php echo esc_attr($numero_posts_totales); ?>">
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('numero_posts_mostrar'); ?>"><?php _e('Número de posts a mostrar', 'os_cards_widget'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('numero_posts_mostrar'); ?>" name="<?php echo $this->get_field_name('numero_posts_mostrar'); ?>" type="number" value="<?php echo esc_attr($numero_posts_mostrar); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('tipo_post'); ?>"><?php _e('Tipo de post', 'os_cards_widget'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('tipo_post'); ?>" name="<?php echo $this->get_field_name('tipo_post'); ?>">
					<option value="publicacion" <?php $selected = ($tipo_post == 'publicacion') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Publicación', 'os_cards_widget'); ?></option>
					<option value="historia" <?php $selected = ($tipo_post == 'historia') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Historia', 'os_cards_widget'); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('plantilla'); ?>"><?php _e('Plantilla para mostrar', 'os_cards_widget'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('plantilla'); ?>" name="<?php echo $this->get_field_name('plantilla'); ?>">
					<option value="plantilla_1" <?php $selected = ($plantilla == 'plantilla_1') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('3 posts en cada línea', 'os_cards_widget'); ?></option>
					<option value="plantilla_2" <?php $selected = ($plantilla == 'plantilla_2') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('2 posts en una línea, 3 en otra', 'os_cards_widget'); ?></option>
					<option value="plantilla_3" <?php $selected = ($plantilla == 'plantilla_3') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('1 post a la izquierda, 2 posts a la derecha', 'os_cards_widget'); ?></option>
				</select>
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('enlace_detalle'); ?>"><?php _e('Enlace a detalle', 'os_cards_widget'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('enlace_detalle'); ?>" name="<?php echo $this->get_field_name('enlace_detalle'); ?>" type="url" value="<?php echo esc_attr($enlace_detalle); ?>">
			</p>
			<p>
				<input class="widefat" id="<?php echo $this->get_field_id('filtrar_por_autor'); ?>" name="<?php echo $this->get_field_name('filtrar_por_autor'); ?>" type="checkbox" <?php checked($instance['filtrar_por_autor'], 'on'); ?>>
				<label for="<?php echo $this->get_field_id('filtrar_por_autor'); ?>"><?php _e('Filtrar por autor', 'os_cards_widget'); ?></label>
			</p>
			<?php
	    }


	    // Guardar configuracion del widget
	    function update($new_instance, $old_instance) {

	    	$instance = $old_instance;

			$instance['titulo'] = (!empty($new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : '';
	    	$instance['texto'] = (!empty($new_instance['texto'])) ? strip_tags($new_instance['texto']) : '';
	    	$instance['numero_posts_totales'] = (!empty($new_instance['numero_posts_totales'])) ? strip_tags($new_instance['numero_posts_totales']) : 0;
	    	$instance['numero_posts_mostrar'] = (!empty($new_instance['numero_posts_mostrar'])) ? strip_tags($new_instance['numero_posts_mostrar']) : 0;
	    	$instance['plantilla'] = (!empty($new_instance['plantilla'])) ? strip_tags($new_instance['plantilla']) : '';
	    	$instance['tipo_post'] = (!empty($new_instance['tipo_post'])) ? strip_tags($new_instance['tipo_post']) : '';
	    	$instance['enlace_detalle'] = (!empty($new_instance['enlace_detalle'])) ? strip_tags($new_instance['enlace_detalle']) : '';
	    	$instance['filtrar_por_autor'] = (!empty($new_instance['filtrar_por_autor'])) ? strip_tags($new_instance['filtrar_por_autor']) : false;

			return $instance;

	    }

	}

	function os_cards_widget() {
	    register_widget('os_cards_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_cards_widget');


endif;
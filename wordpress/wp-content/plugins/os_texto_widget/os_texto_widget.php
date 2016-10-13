<?php

/*
	Plugin Name: OS Texto Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Muestra un widget con título, texo destacado y texto
	Version: 1.0
	Author: Roberto Ojosnegros
	Author URI: http://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_texto_widget
*/


if (!class_exists('OSTextoWidget')) :

	class OSTextoWidget extends WP_Widget {

	    function __construct() {
	        parent::__construct(
	        	'OSTextoWidget',
	        	__('OS Texto Widget', 'os_texto_widget'),
	        	array(
	            	'description' => __('Muestra un widget con título, texo destacado y texto', 'os_texto_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {

    	?>

    		<section class="who-we-are-wrapper wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
		      <div class="container">
		        <h1><?php echo $instance['titulo']; ?></h1>
		        <h2><?php echo $instance['texto_destacado']; ?></h2>
		        <p><?php echo $instance['texto']; ?></p>
		      </div>
		    </section>

	    	<?php

	    }


	    public function form($instance) {
	    	$titulo = ! empty($instance['titulo']) ? $instance['titulo'] : '';
	    	$texto_destacado = ! empty($instance['texto_destacado']) ? $instance['texto_destacado'] : '';
	    	$texto = ! empty($instance['texto']) ? $instance['texto'] : '';
	    	
	    	?>
	    	<p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título:', 'os_texto_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('texto_destacado'); ?>"><?php _e('Texto destacado:', 'os_texto_widget'); ?></label>
				<textarea rows="3" class="widefat" id="<?php echo $this->get_field_id('texto_destacado'); ?>" name="<?php echo $this->get_field_name('texto_destacado'); ?>" type="text"><?php echo esc_attr($texto_destacado); ?></textarea>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto:', 'os_texto_widget'); ?></label>
				<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>" type="text"><?php echo esc_attr($texto); ?></textarea>
			</p>
			<?php
	    }


	    function update($new_instance, $old_instance) {

			$instance = $old_instance;

			$instance['titulo'] = (!empty( $new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : '';
			$instance['texto_destacado'] = (!empty( $new_instance['texto_destacado'])) ? strip_tags($new_instance['texto_destacado']) : '';
			$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : '';

			return $instance;
	    }

	}

	function os_texto_widget() {
	    register_widget('OSTextoWidget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_texto_widget');


endif;
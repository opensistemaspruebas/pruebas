<?php

/*
	Plugin Name: OS Texto Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Muestra un widget con título, texto destacado y texto
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
	            	'description' => __('Muestra un widget con título, texto destacado y texto', 'os_texto_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {

    	?>
    		<?php if($instance['color_fondo'] == 'blanco') : ?>
	    		<section class="who-we-are-wrapper wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
			      <div class="container">
			        <h1><?php echo $instance['titulo']; ?></h1>
			        <h2><?php echo $instance['texto_destacado']; ?></h2>
			        <p><?php echo $instance['texto']; ?></p>
			      </div>
			    </section>
		    <?php endif; ?>

		    <?php if($instance['color_fondo'] == 'gris') : ?>
			    <section class="people-grid-wrapper wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
			      <div class="container">
			        <h1><?php echo $instance['titulo']; ?></h1>
			        <h2><?php echo $instance['texto_destacado']; ?></h2>
			        <?php if($instance['texto'] != ''): ?>
			        	<p><?php echo $instance['texto']; ?></p>
			        <?php endif; ?>
			      </div>
			    </section>
		    <?php endif; ?>

	    	<?php

	    }


	    public function form($instance) {
	    	$titulo = ! empty($instance['titulo']) ? $instance['titulo'] : '';
	    	$texto_destacado = ! empty($instance['texto_destacado']) ? $instance['texto_destacado'] : '';
	    	$texto = ! empty($instance['texto']) ? $instance['texto'] : '';
	    	$color_fondo = ! empty($instance['color_fondo']) ? $instance['color_fondo'] : 'blanco';
	    	
	    	?>

	    	<p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título:', 'os_texto_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>

			<p>
	    		<label>Color de fondo: </label>
				<input id="<?php echo $this->get_field_id('color_fondo') . '-blanco'; ?>" <?php if($color_fondo == 'blanco') echo 'checked'; ?> name="<?php echo $this->get_field_name('color_fondo'); ?>" type="radio" value="blanco"><label for="<?php echo $this->get_field_id('color_fondo') . '-blanco'; ?>"><?php _e('Blanco', 'os_grupo_autores_widget'); ?></label>
				<input id="<?php echo $this->get_field_id('color_fondo') . '-gris'; ?>" <?php if($color_fondo == 'gris') echo 'checked'; ?> name="<?php echo $this->get_field_name('color_fondo'); ?>" type="radio" value="gris"><label for="<?php echo $this->get_field_id('color_fondo') .'-gris'; ?>"><?php _e('Gris', 'os_grupo_autores_widget'); ?></label>
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
			$instance['color_fondo'] = (!empty( $new_instance['color_fondo'])) ? strip_tags($new_instance['color_fondo']) : '';

			return $instance;
	    }

	}

	function os_texto_widget() {
	    register_widget('OSTextoWidget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_texto_widget');


endif;
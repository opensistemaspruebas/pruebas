<?php
/*
Plugin Name: OS Politicas
Plugin URI: https://www.opensistemas.com/
Description: Plugin para editar las políticas de seguridad
Author: Marcos Plaza
Author URI: mplaza@opensistemas.com
Version: 0.0.3
*/
if (!class_exists('OSPoliticas')) :

	class OSPoliticas extends WP_Widget {

	    function __construct() {
	        parent::__construct(
	        	'SPoliticas',
	        	__('OS Politicas Widget', 'os_politicas_widget'),
	        	array(
	            	'description' => __('Widget para editar las politicas de la web', 'os_politicas_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {

?>
<!--Clases alt: who-we-are-wrapper wow fadeIn-->
    		<?php if($instance['color_fondo'] == 'blanco') : ?>
    			<div class="container error404 background-white">
	    		<section class="mb-4xl mt-lg ini wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
			      <div class="container">
			      		<?php if($instance['titulo1'] != ''): ?>
			        		<h1><?php echo $instance['titulo1']; ?></h1>
			        	<?php endif; ?>
			        	<?php if($instance['titulo2'] != ''): ?>
			        		<h2><?php echo $instance['titulo2']; ?></h2>
			        	<?php endif; ?>
			        	<?php if($instance['texto_destacado'] != ''): ?>
			        		<p><strong><?php echo $instance['texto_destacado']; ?></strong></p>
			        	<?php endif; ?>
			        	<?php if($instance['texto'] != ''): ?>
			        		<p><?php echo $instance['texto']; ?></p>
			        	<?php endif; ?>
			        	<?php if($instance['texto_bullet'] != ''): ?>
			        		<ul>
			        			<li><?php echo $instance['texto_bullet']; ?></li>
			        		</ul>
			        	<?php endif; ?>
			        	
			      </div>
			    </section>
			   </div>
		    <?php endif; ?>

<!--Clases alt: people-grid-wrapper who-we-are-wrapper wow fadeIn-->
		    <?php if($instance['color_fondo'] == 'gris') : ?>
		    	<div class="container error404 background-gray">
			    <section class="mb-4xl mt-lg ini wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
			      <div class="container">
			        	<?php if($instance['titulo1'] != ''): ?>
			        		<h1><?php echo $instance['titulo1']; ?></h1>
			        	<?php endif; ?>
			        	<?php if($instance['titulo2'] != ''): ?>
			        		<h2><?php echo $instance['titulo2']; ?></h2>
			        	<?php endif; ?>
			        	<?php if($instance['texto_destacado'] != ''): ?>
			        		<p><strong><?php echo $instance['texto_destacado']; ?></strong></p>
			        	<?php endif; ?>
			        	<?php if($instance['texto'] != ''): ?>
			        		<p><?php echo $instance['texto']; ?></p>
			        	<?php endif; ?>
			        	<?php if($instance['texto_bullet'] != ''): ?>
			        		<ul>
			        			<li><?php echo $instance['texto_bullet']; ?></li>
			        		</ul>
			        	<?php endif; ?>
			        	
			      </div>
			    </section>
			    </div>
		    <?php endif; ?>

	    	<?php

	    }


	    public function form($instance) {
	    	$titulo1 = ! empty($instance['titulo1']) ? $instance['titulo1'] : '';
	    	$titulo2 = ! empty($instance['titulo2']) ? $instance['titulo2'] : '';
	    	$texto_destacado = ! empty($instance['texto_destacado']) ? $instance['texto_destacado'] : '';
	    	$texto = ! empty($instance['texto']) ? $instance['texto'] : '';
	    	$texto_bullet = ! empty($instance['texto_bullet']) ? $instance['texto_bullet'] : '';
	    	$color_fondo = ! empty($instance['color_fondo']) ? $instance['color_fondo'] : 'blanco';

	    	?>

	    	<p>
				<label for="<?php echo $this->get_field_id('titulo1'); ?>"><?php _e('Título de nivel 1:', 'os_politicas_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo1'); ?>" name="<?php echo $this->get_field_name('titulo1'); ?>" type="text" value="<?php echo esc_attr($titulo1); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('titulo2'); ?>"><?php _e('Título de nivel 2:', 'os_politicas_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo2'); ?>" name="<?php echo $this->get_field_name('titulo2'); ?>" type="text" value="<?php echo esc_attr($titulo2); ?>">
			</p>

			<p>
	    		<label>Color de fondo: </label>
				<input id="<?php echo $this->get_field_id('color_fondo') . '-blanco'; ?>" <?php if($color_fondo == 'blanco') echo 'checked'; ?> name="<?php echo $this->get_field_name('color_fondo'); ?>" type="radio" value="blanco"><label for="<?php echo $this->get_field_id('color_fondo') . '-blanco'; ?>"><?php _e('Blanco', 'os_grupo_autores_widget'); ?></label>
				<input id="<?php echo $this->get_field_id('color_fondo') . '-gris'; ?>" <?php if($color_fondo == 'gris') echo 'checked'; ?> name="<?php echo $this->get_field_name('color_fondo'); ?>" type="radio" value="gris"><label for="<?php echo $this->get_field_id('color_fondo') .'-gris'; ?>"><?php _e('Gris', 'os_grupo_autores_widget'); ?></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('texto_destacado'); ?>"><?php _e('Texto destacado:', 'os_politicas_widget'); ?></label>
				<textarea rows="3" class="widefat" id="<?php echo $this->get_field_id('texto_destacado'); ?>" name="<?php echo $this->get_field_name('texto_destacado'); ?>" type="text"><?php echo esc_attr($texto_destacado); ?></textarea>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto:', 'os_politicas_widget'); ?></label>
				<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>" type="text"><?php echo esc_attr($texto); ?></textarea>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('texto_bullet'); ?>"><?php _e('Texto Bullet:', 'os_politicas_widget'); ?></label>
				<textarea rows="1" class="widefat" id="<?php echo $this->get_field_id('texto_bullet'); ?>" name="<?php echo $this->get_field_name('texto_bullet'); ?>" type="text"><?php echo esc_attr($texto_bullet); ?></textarea>
			</p>
			<p>
                <button id="add-bullet" type="button"><?php _e('Añadir Bullet', 'os_politicas_widget')?></button>
            </p>

			
</form>

			<?php
	    }


	    function update($new_instance, $old_instance) {

			$instance = $old_instance;

			$instance['titulo1'] = (!empty( $new_instance['titulo1'])) ? strip_tags($new_instance['titulo1']) : '';
			$instance['titulo2'] = (!empty( $new_instance['titulo2'])) ? strip_tags($new_instance['titulo2']) : '';
			$instance['texto_destacado'] = (!empty( $new_instance['texto_destacado'])) ? strip_tags($new_instance['texto_destacado']) : '';
			$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : '';
			$instance['texto_bullet'] = (!empty( $new_instance['texto_bullet'])) ? strip_tags($new_instance['texto_bullet']) : '';
			$instance['color_fondo'] = (!empty( $new_instance['color_fondo'])) ? strip_tags($new_instance['color_fondo']) : '';

			return $instance;
	    }

	}

	function os_politicas_widget() {
	    register_widget('OSPoliticas');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_politicas_widget');


endif;


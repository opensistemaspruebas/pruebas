<?php
/*
Plugin Name: OS Politicas
Plugin URI: https://www.opensistemas.com/
Description: Plugin para editar las políticas de seguridad
Author: Marcos Plaza
Author URI: mplaza@opensistemas.com
Version: 0.0.3
Text Domain: os_politicas
*/
if (!class_exists('OSPoliticas')) :

	class OSPoliticas extends WP_Widget {

	    function __construct() {
	        parent::__construct(
	        	'OSPoliticas',
	        	__('OS Politicas', 'os_politicas'),
	        	array(
	            	'description' => __('Widget para editar las politicas de la web', 'os_politicas')
	        	)
	        );
	        wp_register_script('os_politicas_js', plugins_url('js/os_politicas.js' , __FILE__), array('jquery'));
	        wp_enqueue_script('os_politicas_js');
        }


	    public function widget($args, $instance) {

	    	$titulo1 = !empty($instance['titulo1']) ? $instance['titulo1'] : '';
	    	$titulo2 = !empty($instance['titulo2']) ? $instance['titulo2'] : '';
	    	$textos_destacados = !empty($instance['textos_destacados']) ? $instance['textos_destacados'] : '';
	    	$textos = !empty($instance['textos']) ? $instance['textos'] : '';
	    	$color_fondo = !empty($instance['color_fondo']) ? $instance['color_fondo'] : 'blanco';
			
?>
			<!--Clases alt: who-we-are-wrapper wow fadeIn-->
    		<?php if($color_fondo == 'blanco') : ?>

					<div class="general-content-text">
		            <div class="container">
		                <section class="mgb-50 mt-lg">
		                	<?php if($titulo1 != ''): ?>
			        			<h1><?php echo $titulo1; ?></h1>
			        		<?php endif; ?>
			        		<?php if($titulo2 != ''): ?>
			        			<h2><?php echo $titulo2; ?></h2>
			        		<?php endif; ?>
			        		<?php if($instance['textos_destacados'] != ''): ?>
			        			<?php foreach ($textos_destacados as $texto_destacado) : ?>
			        				<p><strong><?php echo $texto_destacado; ?></strong></p>
			        			<?php endforeach; ?>
			        		<?php endif; ?>
			        		<?php if($instance['textos'] != ''): ?>
			        			<?php foreach ($textos as $texto) : ?>
			        				<p><?php echo $texto; ?></p>
			        			<?php endforeach; ?>
			        		<?php endif; ?>
		                </section>
		            </div>
		        	</div>	

		    <?php endif; ?>

			<!--Clases alt: people-grid-wrapper who-we-are-wrapper wow fadeIn-->
		    <?php if($color_fondo == 'gris') : ?>

		    		<div class="general-content-text bg-gray">
		           	<div class="container">
		                <section class="mgb-50 mt-lg">
		                	<?php if($titulo1 != ''): ?>
			        			<h1><?php echo $titulo1; ?></h1>
			        		<?php endif; ?>
			        		<?php if($titulo2 != ''): ?>
			        			<h2><?php echo $titulo2; ?></h2>
			        		<?php endif; ?>
			        		<?php if($instance['textos_destacados'] != ''): ?>
			        			<?php foreach ($textos_destacados as $texto_destacado) : ?>
			        				<p><strong><?php echo $texto_destacado; ?></strong></p>
			        			<?php endforeach; ?>
			        		<?php endif; ?>
			        		<?php if($instance['textos'] != ''): ?>
			        			<?php foreach ($textos as $texto) : ?>
			        				<p><?php echo $texto; ?></p>
			        			<?php endforeach; ?>
			        		<?php endif; ?>
		                </section>
		            </div>
		        	</div>	
		    	
		    <?php endif; ?>

	    	<?php

	    }


	    public function form($instance) {

	    	$titulo1 = ! empty($instance['titulo1']) ? $instance['titulo1'] : '';
	    	$titulo2 = ! empty($instance['titulo2']) ? $instance['titulo2'] : '';
	    	$textos_destacados = ! empty($instance['textos_destacados']) ? $instance['textos_destacados'] : '';
	    	$textos = ! empty($instance['textos']) ? $instance['textos'] : '';
	    	$color_fondo = ! empty($instance['color_fondo']) ? $instance['color_fondo'] : 'blanco';

	    	?>

	    	<p>
				<label for="<?php echo $this->get_field_id('titulo1'); ?>"><?php _e('Título de nivel 1:', 'os_politicas'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo1'); ?>" name="<?php echo $this->get_field_name('titulo1'); ?>" type="text" value="<?php echo esc_attr($titulo1); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('titulo2'); ?>"><?php _e('Título de nivel 2:', 'os_politicas'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo2'); ?>" name="<?php echo $this->get_field_name('titulo2'); ?>" type="text" value="<?php echo esc_attr($titulo2); ?>">
			</p>
			<p>
	    		<label>Color de fondo: </label>
				<input id="<?php echo $this->get_field_id('color_fondo') . '-blanco'; ?>" <?php if($color_fondo == 'blanco') echo 'checked'; ?> name="<?php echo $this->get_field_name('color_fondo'); ?>" type="radio" value="blanco"><label for="<?php echo $this->get_field_id('color_fondo') . '-blanco'; ?>"><?php _e('Blanco', 'os_politicas'); ?></label>
				<input id="<?php echo $this->get_field_id('color_fondo') . '-gris'; ?>" <?php if($color_fondo == 'gris') echo 'checked'; ?> name="<?php echo $this->get_field_name('color_fondo'); ?>" type="radio" value="gris"><label for="<?php echo $this->get_field_id('color_fondo') .'-gris'; ?>"><?php _e('Gris', 'os_politicas'); ?></label>
			</p>
			<?php if (empty($textos_destacados)) : ?>
				<div style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;">
                <p>
					<label for="<?php echo $this->get_field_id('textos_destacados').'[0]'; ?>"><?php _e('Texto destacado:', 'os_politicas'); ?></label>
					<textarea rows="4" class="widefat textoDestacado" id="<?php echo $this->get_field_id('textos_destacados') .'[0]'; ?>" name="<?php echo $this->get_field_name('textos_destacados') .'[0]'; ?>" type="text"><?php echo esc_attr($textos_destacados[0]); ?></textarea>
				</p>
				</div>
            <?php else : ?>
 			<?php $i = 0; ?>
                <?php foreach ($textos_destacados as $texto_destacado) : ?>
                	<div style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;">
                	<p>
						<label for="<?php echo $this->get_field_id('textos_destacados') .'['. $i .']'; ?>"><?php _e('Texto destacado:', 'os_politicas'); ?></label>
						<textarea rows="4" class="widefat textoDestacado" id="<?php echo $this->get_field_id('textos_destacados') .'['. $i .']'; ?>" name="<?php echo $this->get_field_name('textos_destacados') .'['. $i .']'; ?>" type="text"><?php echo esc_attr($texto_destacado); ?></textarea>
					</p>
	                <?php if ($i > 0) : ?>
	                        <button id="delete-texto_destacado" type="button"><?php _e('Eliminar este texto destacado', 'os_politicas'); ?></button>
	                <?php endif; ?>	                
	             	</div>
	                <?php $i++; ?>
	            <?php endforeach; ?>
	        <?php endif; ?>
        	<p>
           		<button id="add-texto_destacado" type="button"><?php _e('Añadir texto destacado', 'os_politicas')?></button>
       		</p>

       		<?php if (empty($textos)) : ?>
				<div style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;">
                <p>
					<label for="<?php echo $this->get_field_id('textos').'[0]'; ?>"><?php _e('Texto:', 'os_politicas'); ?></label>
					<textarea rows="4" class="widefat texto" id="<?php echo $this->get_field_id('textos') .'[0]'; ?>" name="<?php echo $this->get_field_name('textos') .'[0]'; ?>" type="text"><?php echo esc_attr($textos[0]); ?></textarea>
				</p>
				</div>
            <?php else : ?>
 			<?php $i = 0; ?>
                <?php foreach ($textos as $texto) : ?>
                	<div style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;">
                	<p>
						<label for="<?php echo $this->get_field_id('textos') .'['. $i .']'; ?>"><?php _e('Texto:', 'os_politicas'); ?></label>
						<textarea rows="4" class="widefat texto" id="<?php echo $this->get_field_id('textos') .'['. $i .']'; ?>" name="<?php echo $this->get_field_name('textos') .'['. $i .']'; ?>" type="text"><?php echo esc_attr($texto); ?></textarea>
					</p>
	                <?php if ($i > 0) : ?>
	                        <button id="delete-texto" type="button"><?php _e('Eliminar este texto', 'os_politicas'); ?></button>
	                <?php endif; ?>	                
	             	</div>
	                <?php $i++; ?>
	            <?php endforeach; ?>
	        <?php endif; ?>
        	<p>
           		<button id="add-texto" type="button"><?php _e('Añadir texto', 'os_politicas')?></button>
       		</p>

			<?php
	    }


	    function update($new_instance, $old_instance) {

			$instance = $old_instance;

			$instance['titulo1'] = (!empty( $new_instance['titulo1'])) ? strip_tags($new_instance['titulo1']) : '';
			$instance['titulo2'] = (!empty( $new_instance['titulo2'])) ? strip_tags($new_instance['titulo2']) : '';
			$instance['color_fondo'] = (!empty( $new_instance['color_fondo'])) ? strip_tags($new_instance['color_fondo']) : '';


            $instance['textos_destacados'] = array();

			if(!empty($new_instance['textos_destacados'])) {
				$i = 0;
				foreach ($new_instance['textos_destacados'] as $texto_destacado) {
					
					$instance['textos_destacados'][$i] = $texto_destacado;
					$i++;
				}
			}


			$instance['textos'] = array();

			if(!empty($new_instance['textos'])) {
				$i = 0;
				foreach ($new_instance['textos'] as $texto) {
					
					$instance['textos'][$i] = $texto;
					$i++;
				}
			}

			return $instance;
	    }

	}

	function os_politicas_widget() {
	    register_widget('OSPoliticas');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_politicas_widget');


endif;


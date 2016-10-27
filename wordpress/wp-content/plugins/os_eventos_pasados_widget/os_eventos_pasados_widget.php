<?php

/*
	Plugin Name: OS Eventos Pasados Widget Subhome
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget para mostrar los eventos pasados
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_eventos_pasados_widget
*/


if (!class_exists('os_eventos_pasados_widget')) :

	class OS_Eventos_Pasados_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_eventos_pasados_widget',
	        	__('OS Eventos Pasados Widget Subhome', 'os_eventos_pasados_widget'),
	        	array(
	            	'description' => __('Widget con los eventos pasados.', 'os_eventos_pasados_widget')
	        	)
	        );
	        if (is_admin()) {
		        wp_enqueue_script('os_eventos_pasados_widget-js', plugins_url( 'js/os_eventos_pasados_widget.js' , __FILE__ ), array('jquery'));
		        wp_enqueue_style('os_eventos_pasados_widget-css', plugin_dir_url( __FILE__ ) . 'css/os_eventos_pasados_widget.css' ); 
		    }
        }


	    public function widget($args, $instance) {

	    	$titulo = $instance['titulo'];
	    	$numero_eventos = $instance['numero_eventos'];

	    	$format = "Y-m-d";

	    	$hoy = current_time($format); 
			
			$args = array(
				'posts_per_page'   => $numero_eventos,
				'offset'           => 0,
				'orderby'          => 'post_date',
				'meta_key' 		   => 'evento_fecha_de_inicio', 
				'order'            => 'ASC',
				'orderby' 		   => 'meta_value',
				'post_type'        => 'evento',
				'post_status'      => 'publish',
				'suppress_filters' => true,
				'meta_query' => array(
			        array(
						'key'         => 'evento_fecha_de_inicio',
						'value'       => $hoy,
						'compare'     => '<',
			        ),
		    	)
			);

	    	$eventos = get_posts($args);

    		$meses = array(
				__("enero", "os_eventos_pasados_widget"), 
				__("febrero", "os_eventos_pasados_widget"), 
				__("marzo", "os_eventos_pasados_widget"), 
				__("abril", "os_eventos_pasados_widget"), 
				__("mayo", "os_eventos_pasados_widget"), 
				__("junio", "os_eventos_pasados_widget"), 
				__("julio", "os_eventos_pasados_widget"), 
				__("agosto", "os_eventos_pasados_widget"), 
				__("septiembre", "os_eventos_pasados_widget"), 
				__("octubre", "os_eventos_pasados_widget"), 
				__("noviembre", "os_eventos_pasados_widget"), 
				__("diciembre", "os_eventos_pasados_widget")
			);


	    	if (!empty($eventos)) {

	    		?>
	    		<section class="past-summits">
				    <div class="container">
				        <div class="row">
				            <header class="col-xs-12">
				                <h2 class="text-center past-summits-title"><?php echo $titulo; ?></h2>
				            </header>
				        </div>
				        <div class="row">
	    		<?php

	    		foreach ($eventos as $evento) {

	    			$evento_localizacion = get_post_meta($evento->ID, 'evento_localizacion', true);

		    		$evento_fecha_de_inicio = get_post_meta($evento->ID, 'evento_fecha_de_inicio', true);

		    		$dateobj_inicio = DateTime::createFromFormat($format, $evento_fecha_de_inicio);

		    		$fecha_evento = '';


		    		$fecha_evento = $dateobj_inicio->format('d') . ' ' . __('de', 'os_eventos_pasados_widget') . ' ' . $meses[$dateobj_inicio->format('m') - 1] . ', ' . $dateobj_inicio->format('Y');
		    		

		    		$evento_highlights = get_post_meta($evento->ID, 'evento_highlights', true);

		    		$imagenCard = get_post_meta($evento->ID, 'imagenCard', true);
	   
			    	?>
					<section class="col-xs-12">
					   <div class="summit-card">
					       <div class="row">
					           <div class="col-xs-12 col-sm-6 summit-image">
					               <header class="summit-image-title-wrapper">
					                   <p class="text-center hidden-xs text-700"><?php echo $evento->post_title; ?><br><?php echo $dateobj_inicio->format('Y'); ?></p>
					               </header><img src="<?php echo $imagenCard; ?>" alt="<?php echo $evento->post_title; ?>"></div>
					           <div class="col-xs-12 col-sm-6 summit-content">
					               <div class="row">
					                   <header class="col-xs-12">
					                       <p class="summit-mobile-title text-420 hidden-sm hidden-md hidden-lg"><?php echo $evento->post_title; ?></p>
					                   </header>
					                   <div class="col-xs-12">
					                       <div class="header-date text-left"><span class="icon bbva-icon-calendar-01 mr-xs text-501"></span><span class="summit-date"><?php echo $fecha_evento; ?></span></div>
					                       <div class="header-location text-left"><span class="icon bbva-icon-pin mr-xs text-501"></span><span class="summit-location"><?php echo $evento_localizacion[2]; ?></span></div>
					                   </div>
					               </div>
					               <div class="row">
					                   <div class="col-xs-12 summit-highlights">
					                       <p class="summit-highlights-title hidden-xs"><?php _e('HIGHLIGHTS', 'os_eventos_pasados_widget'); ?></p>
					                       <?php if (!empty($evento_highlights)) : ?>
						                       <div class="row">
						                       		<?php foreach ($evento_highlights as $evento_highlight) : ?>
														<div class="col-xs-1">
															<div class="rectangle"></div>
															<div class="pre-rectangle"></div>
														</div>
														<div>
															<p class="summit-highlight-element text-300"><?php echo $evento_highlight; ?></p>
														</div>
													<?php endforeach; ?>
						                       </div>
						                    <?php endif; ?>
					                   </div>
					                   	<div class="col-xs-12 hidden-xs">
					                   		<a href="<?php echo get_permalink($evento->ID); ?>" class="summit-link"><?php _e('Ver evento', 'os_eventos_pasados_widget'); ?></a>
					                   	</div>
					               </div>
					           </div>
					       </div>
					   </div>
					</section>
			    	<?php
			    }
			    ?>		</div>
			        </div>
				</section>
			    <?php
	    	}
	    }


	    public function form($instance) {
	    	$titulo =  !empty($instance['titulo']) ? $instance['titulo'] : '';
	    	$numero_eventos =  !empty($instance['numero_eventos']) ? $instance['numero_eventos'] : 3;
	    	?>
	    	<p>
	    		<?php _e('Este es el widget que muestra los eventos pasados.'); ?>
	    	</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título', 'os_eventos_pasados_widget'); ?></label>
			    <input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo $titulo; ?>" />
	    	</p>
			<p>
			    <label for="<?php echo $this->get_field_id('numero_eventos'); ?>"><?php _e('Numero de eventos a mostrar', 'os_eventos_pasados_widget'); ?></label>
			    <input class="widefat" id="<?php echo $this->get_field_id('numero_eventos'); ?>" name="<?php echo $this->get_field_name('numero_eventos'); ?>" type="number" value="<?php echo $numero_eventos; ?>" />
				<span class="description"><?php _e('Valor por defecto: 3.', 'os_eventos_pasados_widget'); ?></span>
			</p>
	    	<?php

	    }


	    function update($new_instance, $old_instance) {
	    	$instance = array();
	    	$instance['titulo'] = (!empty( $new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : '';
			$instance['numero_eventos'] = (!empty( $new_instance['numero_eventos'])) ? strip_tags($new_instance['numero_eventos']) : 3;
			return $instance;
	    }


	}

	function os_eventos_pasados_widget() {
	    register_widget('os_eventos_pasados_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_eventos_pasados_widget');


endif;
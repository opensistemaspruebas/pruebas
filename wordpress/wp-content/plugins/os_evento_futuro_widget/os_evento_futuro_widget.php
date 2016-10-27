<?php

/*
	Plugin Name: OS Evento Futuro Widget Subhome
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget con el evento futuro
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_evento_futuro_widget
*/


if (!class_exists('os_evento_futuro_widget')) :

	class OS_Evento_Futuro_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_evento_futuro_widget',
	        	__('OS Evento Futuro Widget Subhome', 'os_evento_futuro_widget'),
	        	array(
	            	'description' => __('Widget con el evento futuro.', 'os_evento_futuro_widget')
	        	)
	        );
	        if (is_admin()) {
		        wp_enqueue_script('os_evento_futuro_widget-js', plugins_url( 'js/os_evento_futuro_widget.js' , __FILE__ ), array('jquery'));
		        wp_enqueue_style('os_evento_futuro_widget-css', plugin_dir_url( __FILE__ ) . 'css/os_evento_futuro_widget.css' ); 
		    }
        }


	    public function widget($args, $instance) {

			$args = array(
				'posts_per_page'   => 1,
				'offset'           => 0,
				'orderby'          => 'post_date',
				'meta_key' 		   => 'evento_fecha_de_inicio', 
				'order'            => 'DESC',
				'orderby' 		   => 'meta_value',
				'post_type'        => 'evento',
				'post_status'      => 'publish',
				'suppress_filters' => true,
			);

	    	$evento = get_posts($args);


	    	if (!empty($evento)) {

	    		$evento_localizacion = get_post_meta($evento[0]->ID, 'evento_localizacion', true);

	    		$format = "Y-m-d";

	    		$evento_fecha_de_inicio = get_post_meta($evento[0]->ID, 'evento_fecha_de_inicio', true);
	    		$evento_fecha_de_final = get_post_meta($evento[0]->ID, 'evento_fecha_de_final', true);

	    		$dateobj_inicio = DateTime::createFromFormat($format, $evento_fecha_de_inicio);
	    		$dateobj_final = DateTime::createFromFormat($format, $evento_fecha_de_final);

	    		$fecha_evento = '';
	    		$meses = array(
					__("enero", "os_evento_futuro_widget"), 
					__("febrero", "os_evento_futuro_widget"), 
					__("marzo", "os_evento_futuro_widget"), 
					__("abril", "os_evento_futuro_widget"), 
					__("mayo", "os_evento_futuro_widget"), 
					__("junio", "os_evento_futuro_widget"), 
					__("julio", "os_evento_futuro_widget"), 
					__("agosto", "os_evento_futuro_widget"), 
					__("septiembre", "os_evento_futuro_widget"), 
					__("octubre", "os_evento_futuro_widget"), 
					__("noviembre", "os_evento_futuro_widget"), 
					__("diciembre", "os_evento_futuro_widget")
				);
	    		if ($dateobj_inicio->format('m') == $dateobj_final->format('m') && $dateobj_inicio->format('Y') == $dateobj_final->format('Y')) {
	    			$fecha_evento = $dateobj_inicio->format('d') . '-' . $dateobj_final->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_inicio->format('m') - 1] . ', ' . $dateobj_inicio->format('Y');
	    		} else if ($dateobj_inicio->format('Y') == $dateobj_final->format('Y')) {
	    			$fecha_evento = $dateobj_inicio->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_inicio->format('m') - 1] . '-' . $dateobj_final->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_final->format('m') - 1] . ', ' . $dateobj_inicio->format('Y');
	    		} else {
	    			$fecha_evento = $dateobj_inicio->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_inicio->format('m') - 1] . ', ' . $dateobj_inicio->format('Y') . '-' . $dateobj_final->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_final->format('m') - 1] . ', ' . $dateobj_final->format('Y');
	    		}


	    	?>
			<section class="block-image summit wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
			    <div class="img-overlay  summits-page ">
			        <div class="overlay"></div>
			        <img src="<?php echo $instance['imagen_fondo']; ?>" alt="image title">
			    </div>
			    <div class="container">
			        <div class="block-content-center">
			            <h1 class="bold summit-title"><?php _e('Eventos', 'os_evento_futuro_widget'); ?></h1>
			            <label><?php _e('Próximo evento', 'os_evento_futuro_widget'); ?></label>
			            <h2 class="mt-xs mb-sm"><?php echo $evento[0]->post_title; ?></h2>
			            <div class="row">
			            	<span class="col-xs-6 col-sm-4 info-event"><span class="icon bbva-icon-calendar-01 mr-xs"></span><span><?php echo $fecha_evento; ?></span></span>
			            	<span class="col-xs-6 col-sm-3 info-event"><span class="icon bbva-icon-pin mr-xs"></span><span><?php echo $evento_localizacion[2]; ?></span></span>
			            </div>
			            <div class="content-wrap">
			                <p class="mt-md"><?php echo get_post_meta($evento[0]->ID, 'evento_descripcion_corta', true); ?></p>
			            </div>
			            <div class="container-button mt-lg">
			            	<a href="<?php echo get_permalink($evento[0]->ID); ?>" class="col-sm-offset-0 col-sm-3 btn btn-bbva-dark-blue  big "><?php _e('Ver evento', 'os_evento_futuro_widget'); ?></a>
			            </div>
			        </div>
			    </div>
			</section>
	    	<?php
	    	}
	    }


	    public function form($instance) {
	    	$imagen_fondo =  !empty($instance['imagen_fondo']) ? $instance['imagen_fondo'] : '';
	    	$args = array(
			    'depth'                 => 0,
			    'child_of'              => 0,
			    'selected'              => $subhome_eventos,
			    'echo'                  => 1,
			    'name'                  => $this->get_field_name('subhome_eventos'),
			    'id'                    => $this->get_field_id('subhome_eventos'), // string
			    'class'                 => 'widefat', // string
			    'show_option_none'      => null, // string
			    'show_option_no_change' => null, // string
			    'option_none_value'     => null, // string
			);
	    	?>
	    	<p>
	    		<?php _e('Este es el widget que muestra el próximo evento que tendrá lugar.'); ?>
	    	</p>
			<p>
			    <label for="<?php echo $this->get_field_id('imagen_fondo'); ?>"><?php _e('Imagen de fondo', 'os_evento_futuro_widget'); ?></label>
			    <input class="imagen_fondo widefat" id="<?php echo $this->get_field_id('imagen_fondo'); ?>" name="<?php echo $this->get_field_name('imagen_fondo'); ?>" type="text" value="<?php if (!empty($imagen_fondo)) echo $imagen_fondo; ?>" readonly />
			    <img id="show_imagen_fondo" draggable="false" alt="" name="show_imagen_fondo" src="<?php if (!empty($imagen_fondo)) echo esc_attr($imagen_fondo); ?>" style="<?php if (empty($imagen_fondo)) echo "display: none;"; ?>">
			</p>
			<p>
				<input id="evento_futuro_upload_imagen_fondo" name="evento_futuro_upload_imagen_fondo" type="button" value="<?php _e('Explorar/Subir', 'os_evento_futuro_widget'); ?>" />
			</p>
	    	<?php

	    }


	    function update($new_instance, $old_instance) {
	    	$instance = array();
			$instance['imagen_fondo'] = (!empty( $new_instance['imagen_fondo'])) ? strip_tags($new_instance['imagen_fondo']) : '';
			return $instance;
	    }


	}

	function os_evento_futuro_widget() {
	    register_widget('os_evento_futuro_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_evento_futuro_widget');


endif;
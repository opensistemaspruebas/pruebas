<?php

/*
	Plugin Name: OS Evento Widget Home
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget con el evento seleccionado
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_evento_widget_home
*/


if (!class_exists('os_evento_widget_home')) :

	class OS_Evento_Widget_Home extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_evento_widget_home',
	        	__('OS Evento Widget Home', 'os_evento_widget_home'),
	        	array(
	            	'description' => __('Widget con el evento seleccionado.', 'os_evento_widget_home')
	        	)
	        );
	        wp_enqueue_script('os_evento_widget_home-js', plugins_url( 'js/os_evento_widget_home.js' , __FILE__ ), array('jquery'));
	        wp_enqueue_style('os_evento_widget_home-css', plugin_dir_url( __FILE__ ) . 'css/os_evento_widget_home.css' ); 
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

	    	os_imprimir($evento);

	    	if (!empty($evento)) {
	    	?>
			<section class="block-image summit wow fadeInUp">
			    <div class="img-overlay">
			        <div class="overlay"></div>
			        <img src="<?php echo $instance['imagen_fondo']; ?>" alt="image title" />
			    </div>
			    <div class="container">
			        <div class="block-content-center">
			            <label><?php _e('Próximo evento', 'os_evento_widget_home'); ?></label>
			            <h1 class="mt-xs mb-sm"><?php echo $evento[0]->post_title; ?></h1>
			            <div class="row">
			            	<span class="col-xs-6 col-sm-4 info-event"><span class="icon bbva-icon-calendar-01 mr-xs"></span><span>22-23 de octubre, 2017</span></span>
			            	<span class="col-xs-6 col-sm-3 info-event"><span class="icon bbva-icon-pin mr-xs"></span><span><?php $evento_localizacion = get_post_meta($evento[0]->ID, 'evento_localizacion', true); echo $evento_localizacion[2]; ?></span></span>
			            </div>
			            <div class="content-wrap">
			                <p class="mt-md"><?php echo get_post_meta($evento[0]->ID, 'evento_descripcion_corta', true); ?></p>
			            </div>
			            <div class="container-button mt-lg">
			            	<a href="<?php echo get_permalink($evento[0]->ID); ?>" class="col-sm-offset-0 col-sm-3 btn btn-bbva-dark-blue "><?php _e('Ver evento', 'os_evento_widget_home'); ?></a>
			            	<a href="<?php echo get_page_uri($instance['subhome_eventos']); ?>" class="col-xs-12 col-sm-4 mt-md link text-center"><span class="bbva-icon-more mr-xs"></span><?php _e('Ver más eventos', 'os_evento_widget_home'); ?></a>
			            </div>
			        </div>
			    </div>
			</section>
	    	<?php
	    	}
	    }


	    public function form($instance) {
	    	$subhome_eventos = !empty($instance['subhome_eventos']) ? $instance['subhome_eventos'] : 0;
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
			    <label for="<?php echo $this->get_field_id('imagen_fondo'); ?>"><?php _e('Imagen de fondo', 'os_publicacion_type'); ?></label>
			    <input class="imagen_fondo widefat" id="<?php echo $this->get_field_id('imagen_fondo'); ?>" name="<?php echo $this->get_field_name('imagen_fondo'); ?>" type="text" value="<?php if (!empty($imagen_fondo)) echo $imagen_fondo; ?>" readonly />
			    <img id="show_imagen_fondo" draggable="false" alt="" name="show_imagen_fondo" src="<?php if (!empty($imagen_fondo)) echo esc_attr($imagen_fondo); ?>" style="<?php if (empty($imagen_fondo)) echo "display: none;"; ?>">
			</p>
			<p>
				<input id="upload_imagen_fondo" name="upload_imagen_fondo" type="button" value="<?php _e('Explorar/Subir', 'os_publicacion_type'); ?>" />
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('subhome_eventos'); ?>"><?php _e('Subhome de eventos', 'os_texto_widget'); ?></label>
				<?php wp_dropdown_pages($args); ?>
			</p>
	    	<?php

	    }


	    function update($new_instance, $old_instance) {
	    	$instance = array();
			$instance['subhome_eventos'] = (!empty( $new_instance['subhome_eventos'])) ? strip_tags($new_instance['subhome_eventos']) : 0;
			$instance['imagen_fondo'] = (!empty( $new_instance['imagen_fondo'])) ? strip_tags($new_instance['imagen_fondo']) : '';
			return $instance;
	    }


	}

	function os_evento_widget_home() {
	    register_widget('os_evento_widget_home');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_evento_widget_home');


endif;
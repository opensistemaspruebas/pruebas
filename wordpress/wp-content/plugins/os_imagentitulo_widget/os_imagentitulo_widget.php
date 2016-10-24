<?php

/*
	Plugin Name: OS Imagen Título Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Muestra un widget con una imagen y un título superpuesto
	Version: 1.0
	Author: Roberto Ojosnegros
	Author URI: http://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_imagen_titulo_widget
*/


if (!class_exists('OSImagenTituloWidget')) :

	class OSImagenTituloWidget extends WP_Widget {

	    function __construct() {
	        parent::__construct(
	        	'OSImagenTituloWidget',
	        	__('OS Imagen Título Widget', 'os_imagen_titulo_widget'),
	        	array(
	            	'description' => __('Muestra un widget con una imagen y un título superpuesto', 'os_imagen_titulo_widget')
	        	)
	        );
	        add_action( 'admin_enqueue_scripts', array(&$this, 'register_admin_styles'));
            add_action('admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));
            add_action( 'wp_enqueue_scripts', array(&$this, 'register_wp_styles'));
        }


	    public function widget($args, $instance) {
	    	$imagen_url = '';
	    	if($instance['imagen'] != '') {
	    		$imagen_url = wp_get_attachment_url($instance['imagen']);
	    	}
    	?>

    		<header class="wow fadeIn">
		      <span><?php echo $instance['titulo']; ?></span>
		      <img class="img-responsive" src="<?php echo $imagen_url; ?>" alt="">
		    </header>

	    	<?php

	    }


	    public function form($instance) {
	    	$titulo = ! empty($instance['titulo']) ? $instance['titulo'] : '';
	    	$imagen = ! empty($instance['imagen']) ? $instance['imagen'] : '';

	    	if($imagen != '') {
	    		$imagen_url = wp_get_attachment_url($imagen);
	    	}
	    	
	    	?>
	    	<p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título:', 'os_imagen_titulo_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>

			<p class="os_imagentitulo_widget-control" data-title="Selecciona imagen" data-update-text="Selecciona imagen" data-target=".image-id">
				<img src="<?php echo $imagen_url; ?>">
				<input type="hidden" name="<?php echo $this->get_field_name('imagen'); ?>" id="<?php echo $this->get_field_id('imagen'); ?>" value="<?php echo $imagen; ?>" class="image-id os_image_widget-control-target">
				<input id="upload_image" class="button button-hero os_imagentitulo_widget-control-choose" type="button" value="Selecciona imagen"/>
			</p>

			<?php
	    }


	    function update($new_instance, $old_instance) {

			$instance = $old_instance;

			$instance['titulo'] = (!empty( $new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : '';
			$instance['imagen'] = (!empty( $new_instance['imagen'])) ? strip_tags($new_instance['imagen']) : '';

			return $instance;
	    }

	    function register_admin_scripts($hook) {
            wp_enqueue_script('os-imagentitulo-widget-js', plugins_url( 'js/os_imagentitulo_widget.js' , __FILE__ ), array('jquery'));
        }

        /**
         * Adds the meta box stylesheet when appropriate
         */
        function register_admin_styles($hook) {
            wp_enqueue_style( 'os-imagentitulo-widget-css', plugin_dir_url( __FILE__ ) . 'css/os_imagentitulo_widget.css' );
        }

        function register_wp_styles() { 
        	//if(is_active_widget( false, false, $this->id_base, true)) { // check if widget is used
            	wp_enqueue_style( 'os-imagentitulo-front-css', plugin_dir_url( __FILE__ ) . 'css/os_imagentitulo_front.css' ); 
        	//}
        }

	}

	function os_imagen_titulo_widget() {
	    register_widget('OSImagenTituloWidget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_imagen_titulo_widget');


endif;
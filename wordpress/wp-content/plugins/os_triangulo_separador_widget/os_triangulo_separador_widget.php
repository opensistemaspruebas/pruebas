<?php

/*
	Plugin Name: OS Triangulo Separador Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Muestra un widget con una línea ascendente horizontal en degradado gris.
	Version: 1.0
	Author: Roberto Moreno
	Author URI: http://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_triangulo_separador_widget
*/


if (!class_exists('OSTrianguloSeparadorWidget')) :

	class OSTrianguloSeparadorWidget extends WP_Widget {

	    function __construct() {
	        parent::__construct(
	        	'OSTrianguloSeparadorWidget',
	        	__('OS Triangulo Separador Widget', 'os_triangulo_separador_widget'),
	        	array(
	            	'description' => __('Muestra un widget con una línea ascendente horizontal en degradado gris.', 'os_triangulo_separador_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {

	
    	?>

    	    <div class="triangle-separator">
        		<div class="top-triangle"></div>
    		</div>

	    <?php

	    }


	    public function form($instance) {

	    	
	    	?>
	    	
	    	<p><span>Este widget sirve para separar dos wigdet mediante una línea horizontal ascendente con degradado gris.</span></p>
			
						
			<?php
	    }


	    function update($new_instance, $old_instance) {

			$instance = $old_instance;

			return $instance;
	    }

	}

	function os_triangulo_separador_widget() {
	    register_widget('OSTrianguloSeparadorWidget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_triangulo_separador_widget');


endif;
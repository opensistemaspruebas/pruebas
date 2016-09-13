<?php

/*
	Plugin Name: OS Últimas Publicaciones Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra las tres últimas publicaciones del sitio utilizando CloudSearch.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_ultimas_publicaciones_widget
*/


if (!class_exists('OS_Ultimas_Publicaciones_Widget')) :

	class OS_Ultimas_Publicaciones_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_ultimas_publicaciones_widget',
	        	__('OS Últimas Publicaciones', 'os_ultimas_publicaciones_widget'),
	        	array(
	            	'description' => __('Muestra las tres últimas publicaciones del sitio utilizando CloudSearch.', 'os_ultimas_publicaciones_widget')
	        	)
	        );
	        wp_register_script('os_ultimas_publicaciones_widget_js', plugins_url('js/os_ultimas_publicaciones_widget_min.js' , __FILE__), array('jquery'));
	        $translation_array = array(
				'leer_mas' => __('Leer más', 'os_ultimas_publicaciones_widget'),
				'ajaxurl' => admin_url('admin-ajax.php'),
				
			);
			wp_localize_script('os_ultimas_publicaciones_widget_js', 'object_name', $translation_array);
            wp_enqueue_script('os_ultimas_publicaciones_widget_js');
        }


	    public function widget($args, $instance) {

	    	echo $args['before_widget'];

	    	?>
			<div class="wrapperContent">
			    <h2 class="section_titulo"><?php _e("Últimas publicaciones", "os_ultimas_publicaciones_widget"); ?></h2>
			    <ul class="lista_noticias"></ul>
			    <p class="section_verTodos">
			        <a href="http://bbva_proveedores.local/noticias/" class="icon-linkInterno">
			            <em><?php _e("Todas las publicaciones", "os_ultimas_publicaciones_widget"); ?></em>
			        </a>
			    </p>
			</div>
	    	<?php

			echo $args['after_widget'];

	    }


	    public function form($instance) {
	        ?>
	        <p><?php _e('Este widget no tiene parámetros configurables.', 'os_ultimas_publicaciones_widget'); ?></p>
	        <?php
	    }


	    function update($new_instance, $old_instance) {
	    	return $new_instance;
	    }

	}

	function os_ultimas_publicaciones_widget() {
	    register_widget('os_ultimas_publicaciones_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_ultimas_publicaciones_widget');


endif;
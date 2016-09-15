<?php

/*
	Plugin Name: OS Últimas Publicaciones Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra las tres últimas publicaciones.
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
	            	'description' => __('Muestra las tres últimas publicaciones del sitio.', 'os_ultimas_publicaciones_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {

	    	echo $args['before_widget'];

	    	$url_publicaciones = $instance['url_publicaciones'];

	    	$argumentos = array(
				'numberposts' => 3,
				'offset' => 0,
				'category' => 0,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'include' => '',
				'exclude' => '',
				'meta_key' => '',
				'meta_value' =>'',
				'post_type' => 'publicacion',
				'post_status' => 'publish',
				'suppress_filters' => true
			);

			$recent_posts = wp_get_recent_posts($argumentos, ARRAY_A);


			?>

			<div class="wrapperContent">
			    <h2 class="section_titulo"><?php _e("Últimas publicaciones", "os_ultimas_publicaciones_widget"); ?></h2>
			    <?php if (!empty($recent_posts)) : ?>
			    <ul class="lista_noticias">
			    	<?php
			    		$i = 1;
			    		foreach ($recent_posts as $p) {

			    			$post_excerpt = strip_tags($p['post_excerpt']);
			    			$post_excerpt = substr($post_excerpt, 0, 80);
							$post_excerpt = substr($post_excerpt, 0, strrpos($post_excerpt, ' ')) . "...";

							echo '<li id="noticia_' . $i . '" class="col-md-4 col-sm-4 col-xs-12 ">
								    <figure class="contenidoNoticias_boxImage">' . get_the_post_thumbnail($p['ID'], 'medium') . '</figure>
								    <div class="contenidoNoticias_boxTexto">
								        <p class="item_fecha">' . get_the_date('j F Y', $p['ID']) . '</p>
								        <h3 class="item_titulo">' . $p['post_title'] . '</h3>
								        <p class="item_contenido">' . $post_excerpt . '</p>
								        <a target="_blank" href="' . get_permalink($p['ID']) . '">' . __("Leer más", "os_ultimas_publicaciones_widget") . '</a>
								    </div>
								 </li>';
			    			$i++;
			    		}
			    	?>

			    </ul>
			    <p class="section_verTodos">
			        <a href="<?php echo $url_publicaciones; ?>" class="icon-linkInterno">
			            <em><?php _e("Todas las publicaciones", "os_ultimas_publicaciones_widget"); ?></em>
			        </a>
			    </p>
			    <?php else : ?>
			    <p><?php _e("No hay publicaciones disponibles.", "os_ultimas_publicaciones_widget"); ?></p>
			    <?php endif; ?>
			</div>
	    	<?php

			echo $args['after_widget'];

	    }


	    public function form($instance) {
	    	$url_publicaciones = ! empty($instance['url_publicaciones']) ? $instance['url_publicaciones'] : 'http://';
	    	?>
	    	<p>
				<label for="<?php echo $this->get_field_id('url_publicaciones'); ?>"><?php _e('URL de página de todas las publicaciones:', 'os_ultimas_publicaciones_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('url_publicaciones'); ?>" name="<?php echo $this->get_field_name('url_publicaciones'); ?>" type="url" value="<?php echo esc_attr($url_publicaciones); ?>">
			</p>
			<?php
	    }


	    function update($new_instance, $old_instance) {
			$instance = array();
			$instance['url_publicaciones'] = (!empty( $new_instance['url_publicaciones'])) ? strip_tags($new_instance['url_publicaciones']) : '';
			return $instance;
	    }

	}

	function os_ultimas_publicaciones_widget() {
	    register_widget('os_ultimas_publicaciones_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_ultimas_publicaciones_widget');


endif;
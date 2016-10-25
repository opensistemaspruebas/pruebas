<?php

/*
	Plugin Name: OS Twitter Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra los tweet de una cuenta.
	Version: 1.0
	Author: Roberto Moreno
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_twitter_widget
*/


if (!class_exists('OS_Twitter_Widget')) :

	class OS_Twitter_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_twitter_widget',
	        	__('OS Twitter Widget', 'os_twitter_widget'),
	        	array(
	            	'description' => __('Widget que muestra tweets asociados a una cuenta', 'os_twitter_widget')
	        	)
	        );
	        wp_register_script('os_twitter_widget_js', plugins_url('js/os_twitter_widget.js' , __FILE__), array('jquery'));
	        $translation_array = array(
				'enero' => __('Enero', 'os_twitter_widget'),
				'febrero' => __('Febrero', 'os_twitter_widget'),
				'marzo' => __('Marzo', 'os_twitter_widget'),
				'abril' => __('Abril', 'os_twitter_widget'),
				'mayo' => __('Mayo', 'os_twitter_widget'),
				'junio' => __('Junio', 'os_twitter_widget'),
				'julio' => __('Julio', 'os_twitter_widget'),
				'agosto' => __('Agosto', 'os_twitter_widget'),
				'septiembre' => __('Septiembre', 'os_twitter_widget'),
				'octubre' => __('Octubre', 'os_twitter_widget'),
				'noviembre' => __('Noviembre', 'os_twitter_widget'),
				'diciembre' => __('Diciembre', 'os_twitter_widget'),
				
			);
			wp_localize_script('os_twitter_widget_js', 'object_name_twitter', $translation_array);
            wp_enqueue_script('os_twitter_widget_js');
        }


	    public function widget($args, $instance) {

	    	//print_r($instance);

	    	$titulo = $instance['titulo'];
	    	$texto = $instance['texto'];
	    	$url_canal = $instance['url_canal'];
	    	$externo4 = $instance['externo4'];

	    	?>
	    	<section class="latests-tweets pt-xl pb-lg wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
			    <div class="container">
			        <header>
			            <p class="icon bbva-icon-twitter"></p>
			            <h1 class="pt-xs pb-sm"><?php echo $titulo; ?></h1>
			            <p><?php echo $texto; ?></p>
			        </header>
			        <section class="container-fluid mt-md mb-md">
			            <div class="row tweets-container">
			            </div>
			        </section>
			        <footer class="pt-md">
			            <div class="row">
			                <div class="col-md-12 text-center">
			                    <a <?php if ($externo4 == "on") echo 'target="_blank"';?> href="<?php echo $url_canal; ?>" class="readmore"><?php _e('Canal oficial de Twitter', 'os_twitter_widget'); ?> <span class="bbva-icon-link_external"></span></a>
			                </div>
			            </div>
			        </footer>
			    </div>
			</section>
	    	<?php
	    }


  		public function form($instance) {


  			$titulo = !empty($instance['titulo']) ? $instance['titulo'] : __('Últimos tweets', 'os_twitter_widget');
  			$texto = !empty($instance['texto']) ? $instance['texto'] : __('Estos son los últimos twits sobre educación financiera en el mundo', 'os_twitter_widget');
  			$url_canal = !empty($instance['url_canal']) ? $instance['url_canal'] : 'http://';
  			$externo4 = $instance['externo4'];


	        ?>
	        <p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título:', 'os_twitter_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>
	       	<p>
	       		<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto:', 'os_twitter_widget'); ?></label>
				<textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>"><?php echo $texto; ?></textarea>
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('url_canal'); ?>"><?php _e('URL del canal de Twitter:', 'os_twitter_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('url_canal'); ?>" name="<?php echo $this->get_field_name('url_canal'); ?>" type="url" value="<?php echo esc_attr($url_canal); ?>">
			</p>
			<p>
				<input class="widefat" type="checkbox" name="<?php echo $this->get_field_name('externo4');?>" <?php checked(${"externo4"}, 'on'); ?>/>
                <span><?php _e("Abrir enlace en una nueva ventana"); ?></span>
			</p>
	        <?php
	    }


	    function update($new_instance, $old_instance) {

	    	$instance = array();
	    	$instance['titulo'] = (!empty( $new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : __('Últimos tweets', 'os_twitter_widget');
	    	$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : __("Estos son los últimos twits sobre educación financiera en el mundo", "os_twitter_widget");
	    	$instance['url_twitter'] = (!empty( $new_instance['url_twitter'])) ? strip_tags($new_instance['url_twitter']) : '';
	    	$instance['externo4'] = strip_tags($new_instance['externo4']);

	    	return $new_instance;
	    }

	}

	function os_twitter_widget() {
	    register_widget('os_twitter_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_twitter_widget');


endif;
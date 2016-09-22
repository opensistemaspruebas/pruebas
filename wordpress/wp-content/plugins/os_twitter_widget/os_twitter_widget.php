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
	        	__('Twitter', 'os_twitter_widget'),
	        	array(
	            	'description' => __('Widget que muestra tweets asociados a una cuenta', 'os_twitter_widget')
	        	)
	        );
	        wp_register_script('os_twitter_widget_js', plugins_url('js/os_twitter_widget.js' , __FILE__), array('jquery'));
	        $translation_array = array(
				'no_results' => __('No results found', 'os_twitter_widget'),
				'more_results' => __('More', 'os_twitter_widget'),
				'sort_by_asc_date' => __('Older', 'os_twitter_widget'),
				'sort_by_desc_date' => __('Recents', 'os_twitter_widget'),
				'sort_by_popular' => __('Popular', 'os_twitter_widget'),
				'ajaxurl' => admin_url('admin-ajax.php'),
				
			);
			wp_localize_script('os_twitter_widget_js', 'object_name', $translation_array);
            wp_enqueue_script('os_twitter_widget_js');
        }


	    public function widget($args, $instance) {

	    	print_r($instance);

	    	$titulo = $instance['titulo'];
	    	$texto = $instance['texto'];
	    	$url_canal = $instance['url_canal'];

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
			                    <a target="_blank" href="<?php echo $url_canal; ?>" class="readmore"><?php _e('Canal oficial de Twitter', 'os_twitter_widget'); ?> <span class="bbva-icon-link_external"></span></a>
			                </div>
			            </div>
			        </footer>
			    </div>
			</section>
	    	<?php
	    }


  		public function form($instance) {


  			$titulo = !empty($instance['titulo']) ? $instance['titulo'] : _('Últimos tweets', 'os_twitter_widget');
  			$texto = !empty($instance['texto']) ? $instance['texto'] : _('Estos son los últimos twits sobre educación financiera en el mundo', 'os_twitter_widget');
  			$url_canal = !empty($instance['url_canal']) ? $instance['url_canal'] : 'http://';


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
	        <?php
	    }


	    function update($new_instance, $old_instance) {

	    	$instance = array();
	    	$instance['titulo'] = (!empty( $new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : _('Últimos tweets', 'os_twitter_widget');
	    	$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : __("Estos son los últimos twits sobre educación financiera en el mundo", "os_twitter_widget");
	    	$instance['url_twitter'] = (!empty( $new_instance['url_twitter'])) ? strip_tags($new_instance['url_twitter']) : '';

	    	return $new_instance;
	    }

	}

	function os_twitter_widget() {
	    register_widget('os_twitter_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_twitter_widget');


endif;
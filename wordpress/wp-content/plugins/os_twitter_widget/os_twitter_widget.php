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
	    	?>
	    	<section class="latests-tweets pt-xl pb-lg wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
			    <div class="container">
			        <header>
			            <p class="icon bbva-icon-twitter"></p>
			            <h1 class="pt-xs pb-sm"><?php _e("Últimos tweets", "os_twitter_widget"); ?></h1>
			            <p><?php _e("Estos son los últimos twits sobre educación financiera en el mundo", "os_twitter_widget"); ?></p>
			        </header>
			        <section class="container-fluid mt-md mb-md">
			            <div class="row tweets-container">
			            </div>
			        </section>
			        <footer class="pt-md">
			            <div class="row">
			                <div class="col-md-12 text-center">
			                    <a href="#" class="readmore"><?php _e('Canal oficial de Twitter', 'os_twitter_widget'); ?> <span class="bbva-icon-link_external"></span></a>
			                </div>
			            </div>
			        </footer>
			    </div>
			</section>
	    	<?php
	    }


  		public function form($instance) {
	        ?>
	        <p><?php _e('Este widget no tiene parámetros configurables.', 'os_twitter_widget'); ?></p>
	        <?php
	    }


	    function update($new_instance, $old_instance) {
	    	return $new_instance;
	    }

	}

	function os_twitter_widget() {
	    register_widget('os_twitter_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_twitter_widget');


endif;
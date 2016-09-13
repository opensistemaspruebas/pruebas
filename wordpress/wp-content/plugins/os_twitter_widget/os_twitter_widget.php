<?php

/*
	Plugin Name: OS Twitter Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra los tres últimos tweet asociados a una cuenta.
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
	            	'description' => __('Widget que muestra los tres últimos tweet asociados a una cuenta', 'os_twitter_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {

	    	echo $args['before_widget'];

			?>

			<?php 
				echo $args['before_title']; 
				_e('Twitter', 'os_twitter_widget');
				echo $args['after_title']; 
			
				
				extract($args);

      			$cuenta = $instance["cuenta"];

      	    if (!empty($cuenta)){
            
            ?>
                
				<a class="twitter-timeline" data-lang="es" data-width="400" data-height="300" data-tweet-limit="3" data-theme="light" data-link-color="#2B7BB9" href="https://twitter.com/<?php echo $cuenta ?>">Tweets by <?php echo $cuenta ?></a> 
				<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

			<?php
			
			}

			echo $args['after_widget'];

	    }


	    public function form($instance) {

	        $defaults = array('cuenta' => '');

	        $instance = wp_parse_args((array)$instance, $defaults);

	        $cuenta = $instance['cuenta'];

			?>
			<label for="inputText" class="widefat"><?php _e('Cuenta de Twitter:', 'os_twitter_widget'); ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name('cuenta');?>"
                   value="<?php echo esc_attr($cuenta);?>"/>

	        <?php
	    }


	    function update($new_instance, $old_instance) {

	    	$instance = $old_instance;
        	
        	$instance['cuenta'] = strip_tags($new_instance['cuenta']);
        	
        	return $new_instance;
	    }


	    function add_styles() {
            wp_enqueue_style('style-os-twitter-widget', plugins_url( 'css/os_twitter_widget.css' , __FILE__));
        }

	}

	function os_twitter_widget() {
	    register_widget('os_twitter_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_twitter_widget');


endif;
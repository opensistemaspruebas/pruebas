<?php

/*
	Plugin Name: OS Quote Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra una cita.
	Version: 1.0
	Author: Roberto Moreno
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_quote_widget
*/


if (!class_exists('OS_Quote_Widget')) :

	class OS_Quote_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_quote_widget',
	        	__('OS Quote Widget', 'os_quote_widget'),
	        	array(
	            	'description' => __('Widget que muestra citas', 'os_quote_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {

	    	//print_r($instance);

	    	$cita = $instance['cita'];
	    	$persona = $instance['persona'];

	    	?>

	    	<div class="impact container">
	    	  	<section class="quote-section mb-xl">
                    <span class="quote-icon bbva-icon-quote pl-lg ml-xl"></span>
                    <div class="quote-rectangle">
                        <h1><?php echo $cita; ?></h1>
                        <p><?php echo $persona; ?></p>
                    </div>
               	</section>
            </div>

	    	<?php
	    }


  		public function form($instance) {

  			$cita = !empty($instance['cita']) ? $instance['cita'] : '';
  			$persona = !empty($instance['persona']) ? $instance['persona'] : '';
  		
	        ?>
	        <p>
				<label for="<?php echo $this->get_field_id('cita'); ?>"><?php _e('Cita:', 'os_quote_widget'); ?></label>
				<textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('cita'); ?>" name="<?php echo $this->get_field_name('cita'); ?>"><?php echo $cita; ?></textarea>
				
			</p>
	       	<p>
	       		<label for="<?php echo $this->get_field_id('persona'); ?>"><?php _e('Nombre y cargo:', 'os_quote_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('persona'); ?>" name="<?php echo $this->get_field_name('persona'); ?>" type="text" value="<?php echo esc_attr($persona); ?>">
			</p>
	        <?php
	    }


	    function update($new_instance, $old_instance) {

	    	$instance = array();
	
	    	$instance['cita'] = (!empty( $new_instance['cita'])) ? strip_tags($new_instance['cita']) : '';
			$instance['persona'] = (!empty( $new_instance['persona'])) ? strip_tags($new_instance['persona']) : '';

	    	return $new_instance;
	    }

	}

	function os_quote_widget() {
	    register_widget('os_quote_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_quote_widget');


endif;
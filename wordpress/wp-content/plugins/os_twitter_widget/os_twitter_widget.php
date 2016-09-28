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

	    	echo $args['before_widget'];


	    	//Url donde esta nuestro JSON
$req = 'http://dquteo8n8b00y.cloudfront.net/bbva-components/twitter/?project=irnbsadx&baseUri=https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=BBVALiteracy&count=3';

//https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=BBVALiteracy&count=3


//Iniciamos cURL junto con la URL
$cVimeo = curl_init($req);

//Agregamos opciones necesarias para leer
curl_setopt($cVimeo,CURLOPT_RETURNTRANSFER, TRUE);

// Capturamos la URL
$gVimeo = curl_exec($cVimeo);

echo $gVimeo;

//Descodificamos para leer
/*$getVimeo = json_decode($gVimeo,true);

echo $getVimeo;
*/
//Asociamos los campos del JSON a variables
/*$titulo = $getVimeo['title'];
$descripcion = $getVimeo['description'];
$thumbnail = $getVimeo['thumbnail_url'];*/



	
			?>
			
			 <p><?php _e('Todo correcto.', 'os_twitter_widget'); ?></p>
			
			<?php

			echo $args['after_widget'];

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
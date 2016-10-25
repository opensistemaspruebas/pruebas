<?php

/*
	Plugin Name: OS Evento Widget Home
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget con el evento seleccionado
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_evento_widget_home
*/


if (!class_exists('os_evento_widget_home')) :

	class OS_Evento_Widget_Home extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_evento_widget_home',
	        	__('OS Evento Widget Home', 'os_evento_widget_home'),
	        	array(
	            	'description' => __('Widget con el evento seleccionado.', 'os_evento_widget_home')
	        	)
	        );
        }


	    public function widget($args, $instance) {
	    	
	    	/*$title = $instance['title'];
	    	$texto = $instance['texto'];
	    	$tipo_widget = $instance['tipo_widget'];
	    	$impacto_1 = $instance['impacto_1'];
	    	$impacto_2 = $instance['impacto_2'];
	    	$impacto_3 = $instance['impacto_3'];
	    	$url_impactos = $instance['url_impactos'];*/


	    	?>
			<section class="block-image summit wow fadeInUp">
			    <div class="img-overlay ">
			        <div class="overlay"></div><img src="images/home/summit.png" alt="image title" /></div>
			    <div class="container">
			        <div class="block-content-center">
			            <label>Próximo evento</label>
			            <h1 class="mt-xs mb-sm">Anual Summit 2017</h1>
			            <div class="row"><span class="col-xs-6 col-sm-4 info-event"><span class="icon bbva-icon-calendar-01 mr-xs"></span><span>22-23 de octubre, 2017</span></span><span class="col-xs-6 col-sm-3 info-event"><span class="icon bbva-icon-pin mr-xs"></span><span>Madrid</span></span>
			            </div>
			            <div class="content-wrap">
			                <p class="mt-md">BBVA Compass is a subsidiary of BBVA Compass Bancshares Inc., a wholly owned subsidiary of the global financial services group BBVA. The BBVA Group operates in over 30 countries, profices financial services to 50 million customers, and employs more than 100,000 people worldwide.</p>
			            </div>
			            <div class="container-button mt-lg"><a href="#" class="col-sm-offset-0 col-sm-3 btn btn-bbva-dark-blue ">Ver evento</a><a href="#" class="col-xs-12 col-sm-4 mt-md link text-center"><span class="bbva-icon-more mr-xs"></span>Ver más eventos</a></div>
			        </div>
			    </div>
			</section>
	    	<?php

	    }


	    public function form($instance) {

	    }


	    function update($new_instance, $old_instance) {
	    	/*$instance = array();
	    	$instance['title'] = (!empty( $new_instance['title'])) ? strip_tags($new_instance['title']) : '';
	    	$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : '';
	    	$instance['tipo_texto'] = (!empty( $new_instance['tipo_texto'])) ? strip_tags($new_instance['tipo_texto']) : '';
	    	$instance['impacto_1'] = (!empty( $new_instance['impacto_1'])) ? strip_tags($new_instance['impacto_1']) : '';
	    	$instance['impacto_2'] = (!empty( $new_instance['impacto_2'])) ? strip_tags($new_instance['impacto_2']) : '';
	    	$instance['impacto_3'] = (!empty( $new_instance['impacto_3'])) ? strip_tags($new_instance['impacto_3']) : '';
			$instance['url_impactos'] = (!empty( $new_instance['url_impactos'])) ? strip_tags($new_instance['url_impactos']) : '';*/
			return $instance;
	    }

	}

	function os_evento_widget_home() {
	    register_widget('os_evento_widget_home');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_evento_widget_home');


endif;
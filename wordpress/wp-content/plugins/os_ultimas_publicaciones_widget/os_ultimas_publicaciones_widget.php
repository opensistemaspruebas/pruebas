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

	    	?>
			<section class="latests-posts pt-xl pb-lg wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
			    <div class="container">
			        <header class="title-description">
			            <h1>Últimas publicaciones</h1>
			            <div class="description-container">
			                <p>Cosulta las últimas publicaciones escritas por expertos de cara a mejorar tu economía y planificación de futuro.</p>
			            </div>
			        </header>
			        <section class="card-container nopadding container-fluid mt-md mb-md">
			            <div class="row">
			                <div class="main-card-container col-xs-12 col-sm-4 noppading">
			                    <!-- main-card -->
			                    <section class="container-fluid main-card">
			                        <header class="row header-container">
			                            <div class="image-container nopadding col-xs-12">
			                                <img class="img-responsive" src="images/home/informe1.png" alt="">
			                            </div>
			                            <div class="hidden-xs floating-text col-xs-9">
			                                <p class="date">27 Agosto 2016</p>
			                                <h1>Beyond Ties and Cofee Mugs...</h1>
			                            </div>
			                        </header>
			                        <div class="row data-container">
			                            <p class="nopadding col-xs-9 date">27 Agosto 2016</p>
			                            <h1 class="title nopadding col-xs-9">Beyond Ties and Cofee Mugs...</h1>
			                            <p>Want to make your dad feel loved this Father's Day? Avoid purchasing the traditional necktie or boring coffee. </p>
			                            <a href="#" class="hidden-xs readmore">Leer más</a>
			                            <footer class="row">
			                                <div class="col-xs-2 col-lg-1">
			                                    <div class="card-icon">
			                                        <span class="icon bbva-icon-quote"></span>
			                                        <div class="triangle triangle-up-left"></div>
			                                        <div class="triangle triangle-down-right"></div>
			                                    </div>
			                                </div>
			                                <div class="col-xs-2 col-lg-1">
			                                    <div class="card-icon">
			                                        <span class="icon bbva-icon-audio"></span>
			                                        <div class="triangle triangle-up-left"></div>
			                                        <div class="triangle triangle-down-right"></div>
			                                    </div>
			                                </div>
			                                <div class="col-xs-2 col-lg-1">
			                                    <div class="card-icon">
			                                        <span class="icon bbva-icon-comments"></span>
			                                        <div class="triangle triangle-up-left"></div>
			                                        <div class="triangle triangle-down-right"></div>
			                                    </div>
			                                </div>
			                            </footer>
			                        </div>
			                    </section>
			                    <!-- EO main-card -->
			                </div>
			                <div class="main-card-container col-xs-12 col-sm-4 noppading">
			                    <!-- main-card -->
			                    <section class="container-fluid main-card">
			                        <header class="row header-container">
			                            <div class="image-container nopadding col-xs-12">
			                                <img class="img-responsive" src="images/home/informe2.png" alt="">
			                            </div>
			                            <div class="hidden-xs floating-text col-xs-9">
			                                <p class="date">24 Agosto 2016</p>
			                                <h1>Lorem ipsum dolor sit amet...</h1>
			                            </div>
			                        </header>
			                        <div class="row data-container">
			                            <p class="nopadding col-xs-9 date">24 Agosto 2016</p>
			                            <h1 class="title nopadding col-xs-9">Lorem ipsum dolor sit amet...</h1>
			                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
			                            <a href="#" class="hidden-xs readmore">Leer más</a>
			                            <footer class="row">
			                                <div class="col-xs-2 col-lg-1">
			                                    <div class="card-icon">
			                                        <span class="icon bbva-icon-quote"></span>
			                                        <div class="triangle triangle-up-left"></div>
			                                        <div class="triangle triangle-down-right"></div>
			                                    </div>
			                                </div>
			                                <div class="col-xs-2 col-lg-1">
			                                    <div class="card-icon">
			                                        <span class="icon bbva-icon-audio"></span>
			                                        <div class="triangle triangle-up-left"></div>
			                                        <div class="triangle triangle-down-right"></div>
			                                    </div>
			                                </div>
			                            </footer>
			                        </div>
			                    </section>
			                    <!-- EO main-card -->
			                </div>
			                <div class="main-card-container col-xs-12 col-sm-4 noppading">
			                    <!-- main-card -->
			                    <section class="container-fluid main-card">
			                        <header class="row header-container">
			                            <div class="image-container nopadding col-xs-12">
			                                <img class="img-responsive" src="images/home/informe3.png" alt="">
			                            </div>
			                            <div class="hidden-xs floating-text col-xs-9">
			                                <p class="date">23 Agosto 2016</p>
			                                <h1>Lorem ipsum dolor</h1>
			                            </div>
			                        </header>
			                        <div class="row data-container">
			                            <p class="nopadding col-xs-9 date">23 Agosto 2016</p>
			                            <h1 class="title nopadding col-xs-9">Lorem ipsum dolor</h1>
			                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
			                            <a href="#" class="hidden-xs readmore">Leer más</a>
			                            <footer class="row">
			                                <div class="col-xs-2 col-lg-1">
			                                    <div class="card-icon">
			                                        <span class="icon bbva-icon-quote"></span>
			                                        <div class="triangle triangle-up-left"></div>
			                                        <div class="triangle triangle-down-right"></div>
			                                    </div>
			                                </div>
			                                <div class="col-xs-2 col-lg-1">
			                                    <div class="card-icon">
			                                        <span class="icon bbva-icon-audio"></span>
			                                        <div class="triangle triangle-up-left"></div>
			                                        <div class="triangle triangle-down-right"></div>
			                                    </div>
			                                </div>
			                            </footer>
			                        </div>
			                    </section>
			                    <!-- EO main-card -->
			                </div>
			            </div>
			        </section>
			        <footer>
			            <div class="row">
			                <div class="col-md-12 text-center">
			                    <a href="#" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span> Todas las publicaciones</a>
			                </div>
			            </div>
			        </footer>
			    </div>
			</section>
	    	<?php

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
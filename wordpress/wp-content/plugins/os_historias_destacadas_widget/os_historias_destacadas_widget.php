<?php

/*
	Plugin Name: OS Historias Destacadas Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra las tres historias destacadas.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_historias_destacadas_widget
*/


if (!class_exists('OS_Historias_Destacadas_Widget')) :

	class OS_Historias_Destacadas_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_historias_destacadas_widget',
	        	__('OS Historias Destacadas', 'os_historias_destacadas_widget'),
	        	array(
	            	'description' => __('Muestra las tres historias destacadas.', 'os_historias_destacadas_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {
	    
	    	?>
			<section class="outstanding-histories pt-xl pb-lg wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
			    <div class="container">
			        <header class="title-description">
			            <h1>Historias destacadas</h1>
			            <div class="description-container">
			                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus augue felis, porttitor quis nibh eget, ante…</p>
			            </div>
			        </header>
			        <div class="card-container container-fluid mt-md mb-md">
			            <div class="row">
			                <div class="main-card-container col-xs-12 col-sm-6 noppading">
			                    <!-- main-card -->
			                    <section class="container-fluid main-card">
			                        <header class="row header-container">
			                            <div class="image-container nopadding col-xs-12">
			                                <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/resources/images/home/historia1.png" alt="">
			                            </div>
			                            <div class="hidden-xs floating-text color-white col-xs-9">
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
			                <div class="hidden-xs secondary-card-container col-sm-6 ">
			                    <div class="_container">
			                        <!-- secondary-card -->
			                        <section class="container-fluid secondary-card">
			                            <div class="row main-container">
			                                <div class="image-container nopadding col-xs-6">
			                                    <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/resources/images/home/historia2.png" alt="">
			                                </div>
			                                <div class="data-container pt-sm pb-sm col-xs-6">
			                                    <div class="row">
			                                        <div class="col-xs-12 color-grey-1">
			                                            <span class="date">24 Agosto 2016</span>
			                                        </div>
			                                    </div>
			                                    <div class="row">
			                                        <div class="col-xs-12 color-grey-1">
			                                            <h1>Lorem ipsum dolor sit amet...</h1>
			                                        </div>
			                                    </div>
			                                    <div class="row">
			                                        <div class="col-xs-12 color-grey-1">
			                                            <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
			                                        </div>
			                                    </div>
			                                    <div class="row">
			                                        <div class="col-xs-12 colorBlue-620">
			                                            <a href="#" class="readmore">Leer más</a>
			                                        </div>
			                                    </div>
			                                    <footer class="row">
			                                        <div class="col-xs-2">
			                                            <div class="card-icon">
			                                                <span class="icon bbva-icon-quote"></span>
			                                                <div class="triangle triangle-up-left"></div>
			                                                <div class="triangle triangle-down-right"></div>
			                                            </div>
			                                        </div>
			                                        <div class="col-xs-2">
			                                            <div class="card-icon">
			                                                <span class="icon bbva-icon-audio"></span>
			                                                <div class="triangle triangle-up-left"></div>
			                                                <div class="triangle triangle-down-right"></div>
			                                            </div>
			                                        </div>
			                                    </footer>
			                                </div>
			                            </div>
			                        </section>
			                        <!-- EO secondary-card -->
			                    </div>
			                    <div class="_container">
			                        <!-- secondary-card -->
			                        <section class="container-fluid secondary-card">
			                            <div class="row main-container">
			                                <div class="image-container nopadding col-xs-6">
			                                    <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/resources/images/home/historia3.png" alt="">
			                                </div>
			                                <div class="data-container pt-sm pb-sm col-xs-6">
			                                    <div class="row">
			                                        <div class="col-xs-12 color-grey-1">
			                                            <span class="date">23 Agosto 2016</span>
			                                        </div>
			                                    </div>
			                                    <div class="row">
			                                        <div class="col-xs-12 color-grey-1">
			                                            <h1>Lorem ipsum dolor</h1>
			                                        </div>
			                                    </div>
			                                    <div class="row">
			                                        <div class="col-xs-12 color-grey-1">
			                                            <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
			                                        </div>
			                                    </div>
			                                    <div class="row">
			                                        <div class="col-xs-12 colorBlue-620">
			                                            <a href="#" class="readmore">Leer más</a>
			                                        </div>
			                                    </div>
			                                    <footer class="row">
			                                        <div class="col-xs-2">
			                                            <div class="card-icon">
			                                                <span class="icon bbva-icon-quote"></span>
			                                                <div class="triangle triangle-up-left"></div>
			                                                <div class="triangle triangle-down-right"></div>
			                                            </div>
			                                        </div>
			                                        <div class="col-xs-2">
			                                            <div class="card-icon">
			                                                <span class="icon bbva-icon-audio"></span>
			                                                <div class="triangle triangle-up-left"></div>
			                                                <div class="triangle triangle-down-right"></div>
			                                            </div>
			                                        </div>
			                                    </footer>
			                                </div>
			                            </div>
			                        </section>
			                        <!-- EO secondary-card -->
			                    </div>
			                </div>
			                <div class="visible-xs main-card-container col-xs-12 noppading">
			                    <!-- main-card -->
			                    <section class="container-fluid main-card">
			                        <header class="row header-container">
			                            <div class="image-container nopadding col-xs-12">
			                                <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/resources/images/home/historia2.png" alt="">
			                            </div>
			                            <div class="hidden-xs floating-text color-white col-xs-9">
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
			                <div class="visible-xs main-card-container col-xs-12 noppading">
			                    <!-- main-card -->
			                    <section class="container-fluid main-card">
			                        <header class="row header-container">
			                            <div class="image-container nopadding col-xs-12">
			                                <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/resources/images/home/historia3.png" alt="">
			                            </div>
			                            <div class="hidden-xs floating-text color-white col-xs-9">
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
			        </div>
			        <footer class="pt-md">
			            <div class="row">
			                <div class="col-md-12 text-center">
			                    <a href="#" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span> Todas las Historias</a>
			                </div>
			            </div>
			        </footer>
			    </div>
			</section>
	    	<?php

	    }


	    public function form($instance) {
	    	
	    	$texto = ! empty($instance['texto']) ? $instance['texto'] : '';
	    	$url_historias = ! empty($instance['url_historias']) ? $instance['url_historias'] : 'http://';
	    	$historia_destacada_1 = ! empty($instance['historia_destacada_1']) ? $instance['historia_destacada_1'] : '';
	    	$historia_destacada_2 = ! empty($instance['historia_destacada_2']) ? $instance['historia_destacada_2'] : '';
	    	$historia_destacada_3 = ! empty($instance['historia_destacada_3']) ? $instance['historia_destacada_3'] : '';
	    	
	    	$args = array(
				'posts_per_page'   => -1,
				'offset'           => 0,
				'category'         => '',
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'include'          => '',
				'exclude'          => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'post_type'        => 'historia',
				'post_mime_type'   => '',
				'post_parent'      => '',
				'post_status'      => 'publish',
				'suppress_filters' => true
			);
			$historias = get_posts($args);

	    	?>
	    	<p><label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto:', 'os_historias_destacadas_widget'); ?></label>
				<textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>"><?php echo $texto; ?></textarea>
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('url_historias'); ?>"><?php _e('URL de página de todas las historias:', 'os_historias_destacadas_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('url_historias'); ?>" name="<?php echo $this->get_field_name('url_historias'); ?>" type="url" value="<?php echo esc_attr($url_historias); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('historia_destacada_1'); ?>"><?php _e('Historia destacada 1:', 'os_historias_destacadas_widget'); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('historia_destacada_1'); ?>" name="<?php echo $this->get_field_name('historia_destacada_1'); ?>">
				  <?php if (!(empty($historias))) : ?>
				  <option value=""><?php _e('Ninguna', 'os_historias_destacadas_widget'); ?></option>
				  <?php foreach ($historias as $h) : ?>
				  <?php $selected = ($h->ID == $historia_destacada_1) ? 'selected="selected"' : ':'; ?>
				  <option value="<?php echo $h->ID; ?>" <?php echo $selected; ?>><?php echo $h->post_title; ?> | <?php echo $h->post_date; ?></option>
				  <?php endforeach; ?>
				  <?php else: ?>
				  <option value=""><?php _e('No hay historias disponibles', 'os_historias_destacadas_widget'); ?></option>
				  <?php endif; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('historia_destacada_2'); ?>"><?php _e('Historia destacada 2:', 'os_historias_destacadas_widget'); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('historia_destacada_2'); ?>" name="<?php echo $this->get_field_name('historia_destacada_2'); ?>">
				  <?php if (!(empty($historias))) : ?>
				  <option value=""><?php _e('Ninguna', 'os_historias_destacadas_widget'); ?></option>
				  <?php foreach ($historias as $h) : ?>
				  <?php $selected = ($h->ID == $historia_destacada_2) ? 'selected="selected"' : ':'; ?>
				  <option value="<?php echo $h->ID; ?>" <?php echo $selected; ?>><?php echo $h->post_title; ?> | <?php echo $h->post_date; ?></option>
				  <?php endforeach; ?>
				  <?php else: ?>
				  <option value=""><?php _e('No hay historias disponibles', 'os_historias_destacadas_widget'); ?></option>
				  <?php endif; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('historia_destacada_3'); ?>"><?php _e('Historia destacada 3:', 'os_historias_destacadas_widget'); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('historia_destacada_3'); ?>" name="<?php echo $this->get_field_name('historia_destacada_3'); ?>">
				  <?php if (!(empty($historias))) : ?>
				  <option value=""><?php _e('Ninguna', 'os_historias_destacadas_widget'); ?></option>
				  <?php foreach ($historias as $h) : ?>
				  <?php $selected = ($h->ID == $historia_destacada_3) ? 'selected="selected"' : ':'; ?>
				  <option value="<?php echo $h->ID; ?>" <?php echo $selected; ?>><?php echo $h->post_title; ?> | <?php echo $h->post_date; ?></option>
				  <?php endforeach; ?>
				  <?php else: ?>
				  <option value=""><?php _e('No hay historias disponibles', 'os_historias_destacadas_widget'); ?></option>
				  <?php endif; ?>
				</select>
			</p>

	    	<?php
	    }


	    function update($new_instance, $old_instance) {
	    	$instance = array();
	    	$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : '';
	    	$instance['historia_destacada_1'] = (!empty( $new_instance['historia_destacada_1'])) ? strip_tags($new_instance['historia_destacada_1']) : '';
	    	$instance['historia_destacada_2'] = (!empty( $new_instance['historia_destacada_2'])) ? strip_tags($new_instance['historia_destacada_2']) : '';
	    	$instance['historia_destacada_3'] = (!empty( $new_instance['historia_destacada_3'])) ? strip_tags($new_instance['historia_destacada_3']) : '';
			$instance['url_historias'] = (!empty( $new_instance['url_historias'])) ? strip_tags($new_instance['url_historias']) : '';
			return $instance;
	    }

	}

	function os_historias_destacadas_widget() {
	    register_widget('os_historias_destacadas_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_historias_destacadas_widget');


endif;
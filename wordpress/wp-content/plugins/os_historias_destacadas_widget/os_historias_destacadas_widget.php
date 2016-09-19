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
	    
	    	echo $args['before_widget'];

	    	$texto = $instance['texto'];
	    	$historia_destacada_1 = $instance['historia_destacada_1'];
	    	$historia_destacada_2 = $instance['historia_destacada_2'];
	    	$historia_destacada_3 = $instance['historia_destacada_3'];
	    	$url_historias = $instance['url_historias'];

	    	$post__in = array();
	    	if ($historia_destacada_1) {
	    		array_push($post__in, $historia_destacada_1);
	    	}
	    	if ($historia_destacada_2) {
	    		array_push($post__in, $historia_destacada_2);
	    	}
	    	if ($historia_destacada_3) {
	    		array_push($post__in, $historia_destacada_3);
	    	}

	    	if (!(empty($post__in))) {
	    		$historias = get_posts(
	    			array(
					    'include'   => $post__in,
					    'post_type' => 'historia',
					    'orderby'   => 'post__in',
					)
				);
	    	}


			?>
			<!-- banner simple -->
            <section class="outstanding-histories pt-xl pb-lg">
                <div class="container">
                    <header>
                        <div class="row title-container">
                            <div class="col-md-12 text-center">
                                <h1><?php _e("Historias destacadas", "os_historias_destacadas_widget"); ?></h1>
                            </div>
                        </div>
                        <div class="row description-container">
                            <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 text-center">
                                <p class="description"><?php echo $texto; ?></p>
                            </div>
                        </div>
                    </header>
                    <div class="card-container container-fluid mt-md mb-md">
                        <div class="row">
			            <?php if (!empty($historias)) : ?>
			            <?php

				           	// Primera historia
				           	if (!empty($historias[0])) {
				           		$p = $historias[0];
				           		$post_content = strip_tags($p->post_content);
				    			if (!empty($post_content)) {
					    			$post_content = substr($post_content, 0, 80);
									$post_content = substr($post_content, 0, strrpos($post_content, ' ')) . "...";
								}

								?>
								<div class="main-card-container col-xs-12 col-sm-6 col-md-6 col-lg-6 noppading">
								    <section class="container-fluid main-card">
								        <header class="row header-container">
								            <div class="image-container nopadding col-xs-12 col-sm-12 col-md-12 col-lg-12">
								                <img class="img-responsive" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'thumbnail')[0]; ?>" alt="" />
								            </div>
								            <div class="floating-text color-white col-xs-9 col-sm-9 col-md-9 col-lg-9">
								                <span class="date"><?php echo get_the_date('j F Y', $p->ID); ?></span>
								                <h1 class="title font-xxxl"><?php echo $p->post_title; ?></h1>
								            </div>
								        </header>
								        <div class="row data-container">
								            <p><?php echo $post_content; ?></p>
								            <a href="<?php echo get_permalink($p->ID); ?>" class="readmore"><?php _e("Leer más", "os_historias_destacadas_widget"); ?></a>
								            <footer class="row">
								            	<?php if (get_post_meta($p->ID, 'publicacion_pdf')): ?>
								                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
								                    <div class="card-icon">
								                        <span class="icon bbva-icon-quote"></span>
								                        <div class="triangle triangle-up-left"></div>
								                        <div class="triangle triangle-down-right"></div>
								                    </div>
								                </div>
								                <?php endif; ?>
								                <?php if (!empty($post_content)): ?>
								                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
								                    <div class="card-icon">
								                        <span class="icon bbva-icon-comments"></span>
								                        <div class="triangle triangle-up-left"></div>
								                        <div class="triangle triangle-down-right"></div>
								                    </div>
								                </div>
								                <?php endif; ?>
								            </footer>
								        </div>
								    </section>
								</div>
								<?php
				           	}

				           	// Segunda historia
				           	if (!empty($historias[1])) {
				           		$p = $historias[1];
				           		$post_content = strip_tags($p->post_content);
				    			if (!empty($post_content)) {
					    			$post_content = substr($post_content, 0, 80);
									$post_content = substr($post_content, 0, strrpos($post_content, ' ')) . "...";
								}
				           		?>
				           		<div class="hidden-xs secondary-card-container col-sm-6 col-md-6 col-lg-6">
								    <div class="_container">
								        <section class="container-fluid secondary-card">
								            <div class="row main-container">
								                <div class="image-container nopadding col-xs-6 col-sm-6 col-md-6 col-lg-6">
								                    <img class="img-responsive" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'thumbnail')[0]; ?>" alt="" />
								                </div>
								                <div class="data-container pt-sm pb-sm col-xs-6 col-sm-6 col-md-6 col-lg-6">
								                    <div class="row">
								                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 color-grey-1">
								                            <span class="date"><?php echo get_the_date('j F Y', $p->ID); ?></span>
								                        </div>
								                    </div>
								                    <div class="row">
								                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 color-grey-1">
								                            <h1><?php echo $p->post_title; ?></h1>
								                        </div>
								                    </div>
								                    <div class="row">
								                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 color-grey-1">
								                            <p class="description font-xs"><?php echo $post_content; ?></p>
								                        </div>
								                    </div>
								                    <div class="row">
								                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 colorBlue-620">
								                            <a href="<?php echo get_permalink($p->ID); ?>" class="readmore"><?php _e("Leer más", "os_historias_destacadas_widget"); ?></a>
								                        </div>
								                    </div>
								                    <footer class="row">
										            	<?php if (get_post_meta($p->ID, 'publicacion_pdf')): ?>
										                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
										                    <div class="card-icon">
										                        <span class="icon bbva-icon-quote"></span>
										                        <div class="triangle triangle-up-left"></div>
										                        <div class="triangle triangle-down-right"></div>
										                    </div>
										                </div>
										                <?php endif; ?>
										                <?php if (!empty($post_content)): ?>
										                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
										                    <div class="card-icon">
										                        <span class="icon bbva-icon-comments"></span>
										                        <div class="triangle triangle-up-left"></div>
										                        <div class="triangle triangle-down-right"></div>
										                    </div>
										                </div>
										                <?php endif; ?>
								                    </footer>
								                </div>
								            </div>
								        </section>
								    </div>
								    <?php 
								    	// Tercera historia
								    	if (!empty($historias[2])) {
									    	$p = $historias[2];
							           		$post_content = strip_tags($p->post_content);
							    			if (!empty($post_content)) {
								    			$post_content = substr($post_content, 0, 80);
												$post_content = substr($post_content, 0, strrpos($post_content, ' ')) . "...";
											}
									    	?>
										    <div class="_container">
										        <section class="container-fluid secondary-card">
										            <div class="row main-container">
										                <div class="image-container nopadding col-xs-6 col-sm-6 col-md-6 col-lg-6">
										                    <img class="img-responsive" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'thumbnail')[0]; ?>" alt="" />
										                </div>
										                <div class="data-container pt-sm pb-sm col-xs-6 col-sm-6 col-md-6 col-lg-6">
										                    <div class="row">
										                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 color-grey-1">
										                            <span class="date"><?php echo get_the_date('j F Y', $p->ID); ?></span>
										                        </div>
										                    </div>
										                    <div class="row">
										                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 color-grey-1">
										                            <h1><?php echo $p->post_title; ?></h1>
										                        </div>
										                    </div>
										                    <div class="row">
										                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 color-grey-1">
										                            <p class="description font-xs"><?php echo $post_content; ?></p>
										                        </div>
										                    </div>
										                    <div class="row">
										                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 colorBlue-620">
										                            <a href="<?php echo get_permalink($p->ID); ?>" class="readmore"><?php _e("Leer más", "os_historias_destacadas_widget"); ?></a>
										                        </div>
										                    </div>
										                    <footer class="row">
												            	<?php if (get_post_meta($p->ID, 'publicacion_pdf')): ?>
												                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
												                    <div class="card-icon">
												                        <span class="icon bbva-icon-quote"></span>
												                        <div class="triangle triangle-up-left"></div>
												                        <div class="triangle triangle-down-right"></div>
												                    </div>
												                </div>
												                <?php endif; ?>
												                <?php if (!empty($post_content)): ?>
												                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
												                    <div class="card-icon">
												                        <span class="icon bbva-icon-comments"></span>
												                        <div class="triangle triangle-up-left"></div>
												                        <div class="triangle triangle-down-right"></div>
												                    </div>
												                </div>
												                <?php endif; ?>
										                    </footer>
										                </div>
										            </div>
										        </section>
										    </div>
									    	<?php
									    }
								    ?>
				           		</div>
				           		<?php
				           	} else if (!empty($historias[2])) {
				           		$p = $historias[2];
				           		$post_content = strip_tags($p->post_content);
				    			if (!empty($post_content)) {
					    			$post_content = substr($post_content, 0, 80);
									$post_content = substr($post_content, 0, strrpos($post_content, ' ')) . "...";
								}
								?>
								<div class="hidden-xs secondary-card-container col-sm-6 col-md-6 col-lg-6">
								    <div class="_container">
								        <section class="container-fluid secondary-card">
								            <div class="row main-container">
								                <div class="image-container nopadding col-xs-6 col-sm-6 col-md-6 col-lg-6">
								                    <img class="img-responsive" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'thumbnail')[0]; ?>" alt="" />
								                </div>
								                <div class="data-container pt-sm pb-sm col-xs-6 col-sm-6 col-md-6 col-lg-6">
								                    <div class="row">
								                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 color-grey-1">
								                            <span class="date"><?php echo get_the_date('j F Y', $p->ID); ?></span>
								                        </div>
								                    </div>
								                    <div class="row">
								                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 color-grey-1">
								                            <h1><?php echo $p->post_title; ?></h1>
								                        </div>
								                    </div>
								                    <div class="row">
								                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 color-grey-1">
								                            <p class="description font-xs"><?php echo $post_content; ?></p>
								                        </div>
								                    </div>
								                    <div class="row">
								                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 colorBlue-620">
								                            <a href="<?php echo get_permalink($p->ID); ?>" class="readmore"><?php _e("Leer más", "os_historias_destacadas_widget"); ?></a>
								                        </div>
								                    </div>
								                    <footer class="row">
										            	<?php if (get_post_meta($p->ID, 'publicacion_pdf')): ?>
										                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
										                    <div class="card-icon">
										                        <span class="icon bbva-icon-quote"></span>
										                        <div class="triangle triangle-up-left"></div>
										                        <div class="triangle triangle-down-right"></div>
										                    </div>
										                </div>
										                <?php endif; ?>
										                <?php if (!empty($post_content)): ?>
										                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
										                    <div class="card-icon">
										                        <span class="icon bbva-icon-comments"></span>
										                        <div class="triangle triangle-up-left"></div>
										                        <div class="triangle triangle-down-right"></div>
										                    </div>
										                </div>
										                <?php endif; ?>
								                    </footer>
								                </div>
								            </div>
								        </section>
								    </div>
				           		</div>
								<?php
								if (!empty($historias[0])) {
									$p = $historias[0];
									$post_content = strip_tags($p->post_content);
									if (!empty($post_content)) {
										$post_content = substr($post_content, 0, 80);
										$post_content = substr($post_content, 0, strrpos($post_content, ' ')) . "...";
									}
									?>
									<div class="visible-xs main-card-container col-xs-12 noppading">
									    <section class="container-fluid main-card">
									        <header class="row header-container">
									            <div class="image-container nopadding col-xs-12 col-sm-12 col-md-12 col-lg-12">
									                <img class="img-responsive" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'thumbnail')[0]; ?>" alt="" />
									            </div>
									            <div class="floating-text color-white col-xs-9 col-sm-9 col-md-9 col-lg-9">
									                <span class="date"><?php echo get_the_date('j F Y', $p->ID); ?></span>
									                <h1 class="title font-xxxl"><?php echo $p->post_title; ?></h1>
									            </div>
									        </header>
									        <div class="row data-container">
									            <p><?php echo $post_content; ?></p>
									            <a href="<?php echo get_permalink($p->ID); ?>" class="readmore"><?php _e("Leer más", "os_historias_destacadas_widget"); ?></a>
									            <footer class="row">
									            	<?php if (get_post_meta($p->ID, 'publicacion_pdf')): ?>
									                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
									                    <div class="card-icon">
									                        <span class="icon bbva-icon-quote"></span>
									                        <div class="triangle triangle-up-left"></div>
									                        <div class="triangle triangle-down-right"></div>
									                    </div>
									                </div>
									                <?php endif; ?>
									                <?php if (!empty($post_content)): ?>
									                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1">
									                    <div class="card-icon">
									                        <span class="icon bbva-icon-comments"></span>
									                        <div class="triangle triangle-up-left"></div>
									                        <div class="triangle triangle-down-right"></div>
									                    </div>
									                </div>
									                <?php endif; ?>
									            </footer>
									        </div>
									    </section>
									</div>
									<?php
								}
				           	}

			    		?>
			            <?php else: ?>
			            <p><?php _e("No hay historias disponibles.", "os_historias_destacadas_widget"); ?></p>
			            <?php endif; ?>
                        </div>
                    </div>

                    <footer class="pt-md">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a href="<?php echo $url_historias; ?>" class="font-xs"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e("Todas las historias", "os_historias_destacadas_widget"); ?></a>
                            </div>
                        </div>
                    </footer>
                </div>
            </section>
            <!-- EO banner simple -->

	    	<?php

			echo $args['after_widget'];

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
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

		private $meses = array(
			'01' => 'Enero',
			'02' => 'Febrero',
			'03' => 'Marzo',
			'04' => 'Abril',
			'05' => 'Mayo',
			'06' => 'Junio',
			'07' => 'Julio',
			'08' => 'Agosto',
			'09' => 'Septiembre',
			'10' => 'Octubre',
			'11' => 'Noviembre',
			'12' => 'Diciembre',
			);


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

    		$args_publicaciones = array(
				'posts_per_page'   => 3,
				'offset'           => 0,
				'orderby'          => 'date',
				'order'            => 'DESC',
				'post_type'        => 'publicacion',
				'post_status'      => 'publish',
				'suppress_filters' => true 
			);
			$publicaciones = get_posts( $args_publicaciones );

    	?>
			<section class="latests-posts pt-xl pb-lg wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
			    <div class="container">
			        <header class="title-description">
			            <h1><?php _e('Últimas publicaciones', 'os_ultimas_publicaciones_widget') ?></h1>
			            <div class="description-container">
			                <p><?php _e('Cosulta las últimas publicaciones escritas por expertos de cara a mejorar tu economía y planificación de futuro.', 'os_ultimas_publicaciones_widget') ?></p>
			            </div>
			        </header>
			        <section class="card-container nopadding container-fluid mt-md mb-md">
			            <div class="row">

			            	<?php foreach ($publicaciones as $key => $publicacion) : ?>
			            		<?php

			            			$abstract_destacado = get_post_meta($publicacion->ID, 'abstract_destacado', true);
			            			$abstract = get_post_meta($publicacion->ID, 'abstract_contenido', true);
			            			$pdf = get_post_meta($publicacion->ID, 'pdf', true);
			            			$fecha = $this->formatearFecha($publicacion->post_date);
			            			$enlace_publicacion = get_post_permalink($publicacion->ID);
			            			$imagen_id = get_post_thumbnail_id( $publicacion->ID );
			            			$imagen = wp_get_attachment_image_src( $imagen_id, "full" )[0];
			            			$imagen_alt = $image_alt = get_post_meta( $imagen_id, '_wp_attachment_image_alt', true);

			            		?>
			            		<div class="main-card-container col-xs-12 col-sm-4 noppading">
				                    <!-- main-card -->
				                    <section class="container-fluid main-card">
				                        <header class="row header-container">
				                            <div class="image-container nopadding col-xs-12">
				                                <img class="img-responsive" src="<?php echo $imagen; ?>" alt="<?php echo $imagen_alt; ?>">
				                            </div>
				                            <div class="hidden-xs floating-text col-xs-9">
				                                <p class="date"><?php echo $fecha; ?></p>
				                                <h1><?php echo $publicacion->post_title; ?></h1>
				                            </div>
				                        </header>
				                        <div class="row data-container">
				                            <p class="nopadding col-xs-9 date"><?php echo $fecha; ?></p>
				                            <h1 class="title nopadding col-xs-9"><?php echo $publicacion->post_title; ?></h1>
				                            <p><?php echo $abstract_destacado; ?></p>
				                            <a href="<?php echo $enlace_publicacion; ?>" class="hidden-xs readmore"><?php _e('Leer más','os_ultimas_publicaciones_widget'); ?></a>
				                            <footer class="row">
				                            	<?php if ($abstract) : ?>
					                                <div class="col-xs-2 col-lg-1">
					                                    <div class="card-icon">
					                                        <span class="icon bbva-icon-quote"></span>
					                                        <div class="triangle triangle-up-left"></div>
					                                        <div class="triangle triangle-down-right"></div>
					                                    </div>
					                                </div>
				                                <?php endif; ?>
				                                <?php if (false) : ?>
					                                <div class="col-xs-2 col-lg-1">
					                                    <div class="card-icon">
					                                        <span class="icon bbva-icon-audio"></span>
					                                        <div class="triangle triangle-up-left"></div>
					                                        <div class="triangle triangle-down-right"></div>
					                                    </div>
					                                </div>
												<?php endif; ?>
				                                <?php if ($pdf) : ?>
					                                <div class="col-xs-2 col-lg-1">
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
				                    <!-- EO main-card -->
				                </div>

			            	<?php endforeach; ?>

			            </div>
			        </section>
			        <footer>
			            <div class="row">
			                <div class="col-md-12 text-center">
			                    <a href="<?php echo $instance['url_publicaciones']; ?>" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e('Todas las publicaciones', 'os_ultimas_publicaciones_widget') ?></a>
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

	    private function formatearFecha($fecha) {
	    	$fechaFormateada = '';
	    	$fecha = explode(" ",$fecha);
	    	$fecha = explode("-",$fecha[0]);
	    	$anno = $fecha[0];
	    	$mes = $fecha[1];
	    	$dia = $fecha[2];

	    	$fechaFormateada = $dia . ' ' . $this->meses[$mes] . ' ' . $anno;

	    	return $fechaFormateada;
	    }

	}

	function os_ultimas_publicaciones_widget() {
	    register_widget('os_ultimas_publicaciones_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_ultimas_publicaciones_widget');


endif;
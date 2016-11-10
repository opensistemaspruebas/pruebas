<?php

/*
	Plugin Name: OS Logos Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra los logos de las organizaciones y partners asociados.
	Version: 1.0
	Author: Roberto Moreno
	Author URI: rmoreno@opensistemas.com
	License: GPLv2 or later
	Text Domain: os_logos_widget
*/


if (!class_exists('OS_Logos_Widget')) :

	class OS_Logos_Widget extends WP_Widget {



	    function __construct() {
	        parent::__construct(
	        	'os_logos_widget',
	        	__('OS Logos Widget', 'os_logos_widget'),
	        	array(
	            	'description' => __('Widget que muestra los logos de las organizaciones y partners asociados.', 'os_logos_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {

	    	//print_r($instance);

	    	$titulo = $instance['titulo'];
	    	$texto = $instance['texto'];
	    	$tipo_post = (!empty($instance['tipo_post'])) ? $instance['tipo_post'] : 'organizaciones';
	    	$cod_pais = '';
			if(!empty($instance['cod_pais'])) {
				$cod_pais = $instance['cod_pais'];
			}

	    	switch ($tipo_post) {
	    		case 'organizaciones':

					$query = new WP_Query(
						array(
					    	'post_type' => 'organizaciones',
					    	'post_status'      => 'publish',
					    	'posts_per_page'   => 5, 
					    	'orderby' => 'rand',
					    	'suppress_filters' => false
						)
					);
				
					$this->imprime_plantilla_organizaciones($query, $titulo, $texto, $cod_pais);

	    		
	    			break;
	    		case 'partners':

	    			$ambito = $instance['ambito_geografico'];

					$query = new WP_Query(
						array(
					    	'post_type' => 'partners',
					    	'post_status'      => 'publish',
					    	'posts_per_page'   => 6, 
					    	'orderby' => 'rand',
					    	'ambito_geografico' => $ambito,
					    	'suppress_filters' => false
						)
					);

					$this->imprime_plantilla_partners($query, $titulo, $texto, $cod_pais);
	    		
					break;
	    	}

		}




		private function imprime_plantilla_organizaciones($query, $titulo, $texto, $cod_pais) {

				?>

				<section class="council-members">
				<div class="container">
					
					<header class="title-description">
			    		<h1><?php echo $titulo; ?></h1>
			    		<div class="description-container">
			       			<p><?php echo $texto ?></p>
			    		</div>
					</header>
					<div class="text-center">   

					<?php 

						if ($query->have_posts() ) {
						
							while ($query->have_posts()) : $query->the_post();
							
								$post_id = get_the_id();
								$logoMP = get_post_meta($post_id, 'logoMP', true);
			      
			    	?>
			      		<div class="img-map">
					    	<img data-toggle="modal" data-target="#modal-<?php echo $cod_pais . $post_id; ?>" src="<?php echo $logoMP; ?>" alt="image title" />
					    </div>
					    
					<?php
						
				    		endwhile;
							wp_reset_postdata();
						}
						else {
						
							_e("No hay organizaciones disponibles.", "os_logos_widget");
						}
					?>
					
					</div>
				</div>

					<?php 

						if ($query->have_posts() ) {
						
							while ($query->have_posts()) : $query->the_post();
								
								$post_id = get_the_id();
								$nombre = get_post_meta($post_id, 'nombre', true);
								$descripcion = get_post_meta($post_id, 'descripcion', true);
								$link = get_post_meta($post_id, 'link', true);
								$logoMP = get_post_meta($post_id, 'logoMP', true);
								$externo5 = get_post_meta($post_id, 'externo5', true);
			    	?>

				<section class="lightbox modal wow fadeInUp" id="modal-<?php echo $cod_pais . $post_id; ?>" tabindex="-1" role="dialog">
			    	<div class="modal-dialog" role="document">
			        	<div class="modal-content">
			            	<div class="container">
			                	<a rol="button" class="bbva-icon-close pull-right icon-close mt-md mr-md" data-dismiss="modal" aria-label="Close"></a>
			                	<div class="modal-header">
			                    	<h1 class="modal-title"><?php echo $titulo; ?></h1>
			                	</div>
			                	<div class="modal-body mr-xxl ml-xxxl pl-lg">
			                   		<div class="row">
			                        	<div class="col-xs-6 col-xs-offset-4 col-sm-offset-0 col-sm-4 mt-md">
			                            	<img src="<?php echo $logoMP; ?>" alt="image title" />
			                        	</div>
			                        	<div class="col-xs-12 col-sm-8 mt-md">
			                            	<h2 class="text-left ml-md"><?php echo $nombre; ?></h2>
			                            	<p class="ml-md"><?php echo $descripcion; ?></p>
			                        	</div>
			                    	</div>
			                	</div>
			                	<div class="modal-footer">
			                   		<a class="btn btn-bbva-aqua" <?php if ($externo5 == "on") echo 'target="_blank"';?> href="<?php echo $link; ?>" class="btn btn-bbva-aqua"><?php _e("Más información", "os_logos_widget"); ?></a>
			                	</div>
			            	</div>
			        	</div>
			    	</div>
				</section>

					<?php
				    		endwhile;
							wp_reset_postdata();
						} 
					?>

			</section>

				<?php
		}






		private function imprime_plantilla_partners($query, $titulo, $texto, $cod_pais) {


			   if ($query->have_posts() ) { ?>

			      <section class="council-members nopadding">
			        <div class="container">
			          <h2 class="title-map"><?php echo $titulo; ?> <span class="current-country"></span></h2>
			          <div class="text-center">

			   
			      <?php while ($query->have_posts()) : $query->the_post();

			          $post_id = get_the_id();
			          $logoMP = get_post_meta($post_id, 'logoMP', true); 
			      ?>
			      		<div class="img-map">
			          		<img data-toggle="modal" data-target="#modal-<?php echo $cod_pais . $post_id; ?>" src="<?php echo $logoMP; ?>" alt="image title" />
			          	</div>

			      <?php  endwhile; 
			        wp_reset_postdata();
			      ?>

			    </div>
			  </div>

			        <?php while ($query->have_posts()) : $query->the_post(); 

			        	$post_id = get_the_id();
						$nombre = get_post_meta($post_id, 'nombre', true);
						$descripcion = get_post_meta($post_id, 'descripcion', true);
						$link = get_post_meta($post_id, 'link', true);
						$logoMP = get_post_meta($post_id, 'logoMP', true);
						$externo5 = get_post_meta($post_id, 'externo5', true);
			        ?>

			        <section class="lightbox modal wow fadeInUp" id="modal-<?php echo $cod_pais . $post_id; ?>" tabindex="-1" role="dialog">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="container">
			                        <a rol="button" class="bbva-icon-close pull-right icon-close mt-md mr-md" data-dismiss="modal" aria-label="Close"></a>
			                        <div class="modal-header">
			                            <h1 class="modal-title"><?php echo $titulo; ?> <span class="current-country"></h1>
			                        </div>
			                        <div class="modal-body mr-xxl ml-xxxl pl-lg">
			                            <div class="row">
			                                <div class="col-xs-6 col-xs-offset-4 col-sm-offset-0 col-sm-4 mt-md">
			                                    <img src="<?php echo $logoMP; ?>" alt="image title" />
			                                </div>
			                                <div class="col-xs-12 col-sm-8 mt-md">
			                                    <h2 class="text-left ml-md"><?php echo $nombre; ?></h2>
			                                    <p class="ml-md"><?php echo $descripcion; ?></p>
			                                </div>
			                            </div>
			                        </div>
			                        <div class="modal-footer">
			                        	<a <?php if ($externo5 == "on") echo 'target="_blank"';?>" href="<?php echo $link; ?>" class="btn btn-bbva-aqua"><?php _e("Más información"); ?></a>
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </section>
			    
			    <?php endwhile;
			        wp_reset_postdata();
			    ?>

			  </section>


			<?php

				}


		}





  	public function form($instance) {


  			$titulo = !empty($instance['titulo']) ? $instance['titulo'] : __('Organizaciones del consejo asesor', 'os_logos_widget');
  			$texto = !empty($instance['texto']) ? $instance['texto'] : __('Estas son varias de las organizaciones que apoyan a la educación financiera en los diferentes países en los que estamos presentes', 'os_logos_widget');
  			$tipo_post = (!empty($instance['tipo_post'])) ? $instance['tipo_post'] : '';

	        ?>
	        <p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título:', 'os_logos_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>
	       	<p>
	       		<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Descripción:', 'os_logos_widget'); ?></label>
				<textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>"><?php echo $texto; ?></textarea>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('tipo_post'); ?>"><?php _e('Tipo de post', 'os_logos_widget'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('tipo_post'); ?>" name="<?php echo $this->get_field_name('tipo_post'); ?>">
					<option value="organizaciones" <?php $selected = ($tipo_post == 'organizaciones') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Organizaciones', 'os_logos_widget'); ?></option>
					<option value="partners" <?php $selected = ($tipo_post == 'partners') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Partners', 'os_logos_widget'); ?></option>
				</select>
			</p>
	        <?php
	    }


	function update($new_instance, $old_instance) {

	    	$instance = $old_instance;

	    	$instance['titulo'] = (!empty( $new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : __('Organizaciones del consejo asesor', 'os_logos_widget');
	    	$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : __("Estas son varias de las organizaciones que apoyan a la educación financiera en los diferentes países en los que estamos presentes", "os_logos_widget");
	    	$instance['tipo_post'] = (!empty($new_instance['tipo_post'])) ? strip_tags($new_instance['tipo_post']) : '';
	    	$instance['externo5'] = strip_tags($new_instance['externo5']);

	    	return $instance;
	    }

	}

	function os_logos_widget() {
	    register_widget('os_logos_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_logos_widget');


endif;
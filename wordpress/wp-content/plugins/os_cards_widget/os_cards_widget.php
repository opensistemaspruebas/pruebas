<?php

/*
	Plugin Name: OS Cards Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra tarjetas para distintos tipos de posts.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_cards_widget
*/


if (!class_exists('OS_Cards_Widget')) :

	class OS_Cards_Widget extends WP_Widget {

		// Constructor
	    function __construct() {
	        parent::__construct(
	        	'os_cards_widget',
	        	__('OS Cards Widget', 'os_cards_widget'),
	        	array(
	            	'description' => __('Muestra tarjetas para distintos tipos de posts.', 'os_cards_widget')
	        	)
	        );
	        add_action('wp_enqueue_scripts', array(&$this, 'add_script_filter_widget'));
        }


		function add_script_filter_widget() {
            if (is_active_widget(false, false, $this->id_base, true)) {
		        wp_register_script('os_cards_widget_js', plugins_url('js/os_cards_widget.js' , __FILE__), array('jquery'));
	            wp_enqueue_script('os_cards_widget_js');
            }
        } 



        // Widget del front-end
	    public function widget($args, $instance) {

	    	$titulo = (!empty($instance['titulo'])) ? $instance['titulo'] : '';
	    	$texto = (!empty($instance['texto'])) ? $instance['texto'] : '';
	    	$numero_posts_totales = (!empty($instance['numero_posts_totales'])) ? $instance['numero_posts_totales'] : 3;
	    	$numero_posts_mostrar = (!empty($instance['numero_posts_mostrar'])) ? $instance['numero_posts_mostrar'] : 3;
	    	$plantilla = (!empty($instance['plantilla'])) ? $instance['plantilla'] : 'plantilla_1';
	    	$tipo_post = (!empty($instance['tipo_post'])) ? $instance['tipo_post'] : 'publicacion';
	    	$enlace_detalle = (!empty($instance['enlace_detalle'])) ? $instance['enlace_detalle'] : '';

	    	$author = isset($instance['filtrar_por_autor']) ? $curauth->ID : 0;

	    	$args = array(
				'posts_per_page'   => $numero_posts_totales,
				'offset'           => 0,
				'category'         => '',
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'meta_key'         => '',
				'meta_value'       => '',
				'post_type'        => $tipo_post,
				'post_status'      => 'publish',
				'suppress_filters' => true,
				'author'           =>  0,
			);

	    	$posts = get_posts($args);

	    	switch ($plantilla) {
	    		case 'plantilla_1' :
	    			imprime_plantilla_1($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle);
	    			break;
	    		case 'plantilla_2' :
	    			imprime_plantilla_2($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle);
	    			break;
	    		case 'plantilla_3' :
	    			imprime_plantilla_3($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle);
	    			break;
	    	}


	    }

	    // Formulario del back-end
	    public function form($instance) {
	    	
	    	$titulo = (!empty($instance['titulo'])) ? $instance['titulo'] : '';
	    	$texto = (!empty($instance['texto'])) ? $instance['texto'] : '';
	    	$numero_posts_totales = (!empty($instance['numero_posts_totales'])) ? $instance['numero_posts_totales'] : 0;
	    	$numero_posts_mostrar = (!empty($instance['numero_posts_mostrar'])) ? $instance['numero_posts_mostrar'] : 0;
	    	$plantilla = (!empty($instance['plantilla'])) ? $instance['plantilla'] : '';
	    	$tipo_post = (!empty($instance['tipo_post'])) ? $instance['tipo_post'] : '';
	    	$enlace_detalle = (!empty($instance['enlace_detalle'])) ? $instance['enlace_detalle'] : '';
	    	$filtrar_por_autor = isset($instance[ 'filtrar_por_autor' ]) ? $instance['filtrar_por_autor'] : 'off';
	    	
	    	?>	
	    	<p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título', 'os_cards_widget'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto', 'os_cards_widget'); ?>:</label>
				<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>" type="text"><?php echo esc_attr($texto); ?></textarea>
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('numero_posts_totales'); ?>"><?php _e('Número de posts totales', 'os_cards_widget'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('numero_posts_totales'); ?>" name="<?php echo $this->get_field_name('numero_posts_totales'); ?>" type="number" value="<?php echo esc_attr($numero_posts_totales); ?>">
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('numero_posts_mostrar'); ?>"><?php _e('Número de posts a mostrar', 'os_cards_widget'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('numero_posts_mostrar'); ?>" name="<?php echo $this->get_field_name('numero_posts_mostrar'); ?>" type="number" value="<?php echo esc_attr($numero_posts_mostrar); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('tipo_post'); ?>"><?php _e('Tipo de post', 'os_cards_widget'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('tipo_post'); ?>" name="<?php echo $this->get_field_name('tipo_post'); ?>">
					<option value="publicacion" <?php $selected = ($tipo_post == 'publicacion') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Publicación', 'os_cards_widget'); ?></option>
					<option value="historia" <?php $selected = ($tipo_post == 'historia') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Historia', 'os_cards_widget'); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('plantilla'); ?>"><?php _e('Plantilla para mostrar', 'os_cards_widget'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('plantilla'); ?>" name="<?php echo $this->get_field_name('plantilla'); ?>">
					<option value="plantilla_1" <?php $selected = ($plantilla == 'plantilla_1') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('3 posts en cada línea', 'os_cards_widget'); ?></option>
					<option value="plantilla_2" <?php $selected = ($plantilla == 'plantilla_2') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('2 posts en una línea, 3 en otra', 'os_cards_widget'); ?></option>
					<option value="plantilla_3" <?php $selected = ($plantilla == 'plantilla_3') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('1 post a la izquierda, 2 posts a la derecha', 'os_cards_widget'); ?></option>
				</select>
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('enlace_detalle'); ?>"><?php _e('Enlace a detalle', 'os_cards_widget'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('enlace_detalle'); ?>" name="<?php echo $this->get_field_name('enlace_detalle'); ?>" type="url" value="<?php echo esc_attr($enlace_detalle); ?>">
			</p>
			<p>
				<input class="widefat" id="<?php echo $this->get_field_id('filtrar_por_autor'); ?>" name="<?php echo $this->get_field_name('filtrar_por_autor'); ?>" type="checkbox" <?php checked($instance['filtrar_por_autor'], 'on'); ?>>
				<label for="<?php echo $this->get_field_id('filtrar_por_autor'); ?>"><?php _e('Filtrar por autor', 'os_cards_widget'); ?></label>
			</p>
			<?php
	    }


	    // Guardar configuracion del widget
	    function update($new_instance, $old_instance) {

	    	$instance = $old_instance;

			$instance['titulo'] = (!empty($new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : '';
	    	$instance['texto'] = (!empty($new_instance['texto'])) ? strip_tags($new_instance['texto']) : '';
	    	$instance['numero_posts_totales'] = (!empty($new_instance['numero_posts_totales'])) ? strip_tags($new_instance['numero_posts_totales']) : 0;
	    	$instance['numero_posts_mostrar'] = (!empty($new_instance['numero_posts_mostrar'])) ? strip_tags($new_instance['numero_posts_mostrar']) : 0;
	    	$instance['plantilla'] = (!empty($new_instance['plantilla'])) ? strip_tags($new_instance['plantilla']) : '';
	    	$instance['tipo_post'] = (!empty($new_instance['tipo_post'])) ? strip_tags($new_instance['tipo_post']) : '';
	    	$instance['enlace_detalle'] = (!empty($new_instance['enlace_detalle'])) ? strip_tags($new_instance['enlace_detalle']) : '';
	    	$instance['filtrar_por_autor'] = (!empty($new_instance['filtrar_por_autor'])) ? strip_tags($new_instance['filtrar_por_autor']) : false;

			return $instance;

	    }

	}


	// Registrar el widget
	function os_cards_widget() {
	    register_widget('os_cards_widget');
	}

	
	// Inicializar el widget
	add_action('widgets_init', 'os_cards_widget');


endif;


// 3 posts en cada linea
function imprime_plantilla_1($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle) {

	?>
	<section class="latests-posts pt-xl wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
	    <div class="container">
	        <header class="title-description">
	            <h1><?php echo $titulo; ?></h1>
	            <div class="description-container">
	                <p><?php echo $texto; ?></p>
	            </div>
	        </header>
	        <?php if (!empty($posts)) : ?>
	        <section class="card-container nopadding container-fluid mt-md mb-md">
	            <div class="row">
	                    
	                    <?php $i = 0 ;?>
                    	<?php foreach ($posts as $post) : ?>

                    		<?php

                    			$post_title = $post->post_title;
                    			$post_date = get_the_date('j F Y', $post->ID);
                    			$post_guid = $post->guid;
                    			$post_abstract = substr(get_post_meta($post->ID, 'abstract_destacado', true), 0, 140) . '...';
                    			$pdf = get_post_meta($post->ID, 'pdf', true);
		            			$imagen_id = get_post_thumbnail_id($post->ID);
		            			$imagen = wp_get_attachment_image_src($imagen_id, "full")[0];
		            			$imagen_alt = get_post_meta($imagen_id, '_wp_attachment_image_alt', true);

           						$style = '';
           						if (empty($enlace_detalle) && $i >= $numero_posts_mostrar) 
           							$style = 'style="display: none;'; ; 
           					?>
           					<div class="main-card-container col-xs-12 col-sm-4 noppading">
		                    <section class="container-fluid main-card" <?php echo $style; ?>>
		                        <header class="row header-container">
		                            <div class="image-container nopadding col-xs-12">
		                                <img class="img-responsive" src="<?php echo $imagen; ?>" alt="<?php echo $imagen_alt; ?>">
		                            </div>
		                            <div class="hidden-xs floating-text col-xs-9">
		                                <p class="date"><?php echo $post_date; ?></p>
		                                <h1><?php echo $post_title; ?></h1>
		                            </div>
		                        </header>
		                        <div class="row data-container">
		                            <p class="nopadding col-xs-9 date"><?php echo $post_date; ?></p>
		                            <h1 class="title nopadding col-xs-9"><?php echo $post_title; ?></h1>
		                            <p><?php echo $post_abstract; ?></p>
		                            <a href="<?php echo $post_guid; ?>" class="hidden-xs readmore"><?php _e("Leer más", "os_cards_widget"); ?></a>
		                            <footer class="row">
		                            	<?php if ($post_abstract) : ?>
			                                <div class="col-xs-2 col-lg-1">
			                                    <div class="card-icon">
			                                        <span class="icon bbva-icon-quote"></span>
			                                        <div class="triangle triangle-up-left"></div>
			                                        <div class="triangle triangle-down-right"></div>
			                                    </div>
			                                </div>
		                                <?php endif; ?>
		                                <?php if (false) :?>
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
		                    </div>
		                <?php $i++; ?>
		                <?php endforeach; ?>
	            
	            </div>
	        </section>
	        <footer class="grid-footer">
	            <div class="row">
	                <div class="col-md-12 text-center">
	                    <a href="<?php echo $enlace_detalle; ?>" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e("Todas las publicaciones", "os_cards_widget"); ?></a>
	                </div>
	            </div>
	        </footer>
	    	<?php endif; ?>
	    </div>
	</section>
	<?php
}


// 2 posts en una linea, 3 en otra
function imprime_plantilla_2($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle) {
	
	if (empty($enlace_detalle)) {
		?>
		<input type="hidden" name="numero_posts_totales" value="<?php echo $numero_posts_totales; ?>">
		<input type="hidden" name="numero_posts_mostrar" value="<?php echo $numero_posts_mostrar; ?>">
		<?php
	}

	?>
	<article id="publishing-view">
	    <div class="main-wrapper">
	        <header class="container">
	            <h1><?php echo $titulo; ?></h1>
	            <h2><?php echo $texto; ?></h2>
	            <div class="visible-xs mobile-filter">
	                <a href="#"><span class="bbva-icon-filter"></span> <?php _e('filtrar', 'os_cards_widget'); ?></a>
	            </div>
	            <div class="sort-items-container">
	                <a href="#">
	                    <span class="icon bbva-icon-arrow arrowUp"></span>
	                    <span class="text"><?php _e('Más recientes', 'os_cards_widget'); ?></span>
	                </a>
	                <a href="#">
	                    <span class="icon bbva-icon-arrow arrowDown"></span>
	                    <span class="text"><?php _e('Más antiguos', 'os_cards_widget'); ?></span>
	                </a>
	                <a href="#">
	                    <span class="icon bbva-icon-view "></span>
	                    <span class="text"><?php _e('Más leídos', 'os_cards_widget'); ?></span>
	                </a>
	            </div>
	            <a class="filter hidden-xs" href="#"> <span class="bbva-icon-filter"></span> <span><?php _e('Filtrar', 'os_cards_widget'); ?></span> </a>
	        </header>
	        <?php if (!empty($posts)) : ?>
	        <?php $order = array('double', 'double', 'triple', 'triple', 'triple'); ?>
	        <section>
	            <article class="cards-grid">
	                <section class="container">
	                    <div class="row">
	                    	<?php $i = 0 ;?>
	                    	<?php foreach ($posts as $post) : ?>

	                    		<?php 

	                    			$post_title = $post->post_title;
	                    			$post_date = get_the_date('j F Y', $post->ID);
	                    			$post_guid = $post->guid;
	                    			$post_abstract = get_post_meta($post->ID, 'abstract_destacado', true);
	                    			$pdf = get_post_meta($post->ID, 'pdf', true);
			            			$imagen_id = get_post_thumbnail_id($post->ID);
			            			$imagen = wp_get_attachment_image_src($imagen_id, "full")[0];
			            			$imagen_alt = get_post_meta($imagen_id, '_wp_attachment_image_alt', true);

	                    		?>

	           					<?php $grid = $order[($i % 5)]; ?>
	           					<?php 
	           						$style = '';
	           						if (empty($enlace_detalle) && $i >= $numero_posts_mostrar) 
	           							$style = 'style="display: none;'; ; 
	           					?>
	           					<?php if ($grid == "double") : ?>
	           					<div name="card_<?php echo $i; ?>" class="col-xs-12 col-sm-6 double-card card-container" <?php echo $style; ?>>
	           					<?php elseif ($grid == "triple") : ?>
	           					<div name="card_<?php echo $i; ?>" class="col-xs-12 col-sm-4 triple-card card-container" <?php echo $style; ?>>
	           					<?php endif; ?>
								    <section class="container-fluid main-card">
								        <header class="row header-container">
								            <div class="image-container nopadding col-xs-12">
								                <img class="img-responsive" src="<?php echo $imagen; ?>" alt="<?php echo $imagen_alt; ?>">
								            </div>
								            <div class="hidden-xs floating-text col-xs-9">
								                <p class="date"><?php echo $post_date; ?></p>
								                <h1><?php echo $post_title; ?></h1>
								            </div>
								        </header>
								        <div class="row data-container">
								            <p class="nopadding col-xs-9 date"><?php echo $post_date; ?></p>
								            <h1 class="title nopadding col-xs-9"><?php echo $post_title; ?></h1>
								            <p><?php echo $post_abstract; ?></p>
								            <a href="<?php echo $post_guid; ?>" class="hidden-xs readmore"><?php _e('Leer más', 'os_cards_widget'); ?></a>
								            <footer class="row">
					                        <?php if (!empty($abstract_destacado)) : ?>
					                            <div class="col-xs-2 col-lg-1">
					                                <span class="icon bbva-icon-quote"></span>
					                                <div class="triangle triangle-up-left"></div>
					                                <div class="triangle triangle-down-right"></div>
					                            </div>
					                        <?php endif; ?>
					                        <?php if (false) : ?>
					                            <div class="col-xs-2 col-lg-1">
					                                <span class="icon bbva-icon-audio"></span>
					                                <div class="triangle triangle-up-left"></div>
					                                <div class="triangle triangle-down-right"></div>
					                            </div>
					                        <?php endif; ?>
					                        <?php if ($pdf) : ?>
					                            <div class="col-xs-2 col-lg-1">
					                                <span class="icon bbva-icon-comments"></span>
					                                <div class="triangle triangle-up-left"></div>
					                                <div class="triangle triangle-down-right"></div>
					                            </div>
					                        <?php endif; ?>
								            
								            </footer>
								        </div>
								    </section>
	           					</div>
	                    		<?php $i++; ?>
	                    	<?php endforeach; ?>
	                    </div>
	                    <footer class="grid-footer">
	                        <div class="row">
	                            <div class="col-md-12 text-center">
	                                <a href="<?php echo $enlace_detalle; ?>" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e('Más publicaciones', 'os_cards_widget'); ?></a>
	                            </div>
	                        </div>
	                    </footer>
	                </section>
	            </article>
	        </section>
	    	<?php endif; ?>
	    </div>
	</article>
	<?php
}


// 1 post a la izquierda, 2 posts a la derecha
function imprime_plantilla_3($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle) {
	?>
	<section class="outstanding-histories pt-xl wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
	    <div class="container">
	        <header class="title-description">
	            <h1><?php echo $title; ?></h1>
	            <div class="description-container">
	                <p><?php $texto; ?></p>
	            </div>
	        </header>
	        <?php if (!empty($posts)) : ?>
	        <?php $order = array('main', 'secondary', 'secondary'); ?>
	        <div name="card_<?php echo $i; ?>" class="card-container container-fluid mt-md mb-md">
	            <div class="row">
	            	<?php $i = 0 ;?>
	            	<?php foreach ($posts as $post) : ?>
	                <?php 

						$post_title = $post->post_title;
						$post_date = get_the_date('j F Y', $post->ID);
						$post_guid = $post->guid;
						$post_content = $post->post_content;
						$imagen_id = get_post_thumbnail_id($post->ID);
						$imagen = wp_get_attachment_image_src($imagen_id, "full")[0];
						$imagen_alt = get_post_meta($imagen_id, '_wp_attachment_image_alt', true);

						$grid = $order[($i % 3)]; 

						$style = '';
						if (empty($enlace_detalle) && $i >= $numero_posts_mostrar) 
							$style = 'style="display: none;'; ; 

					?>	

					<?php if ($grid == "main") : ?>
					<div name="card_<?php echo $i; ?>" class="_main-card col-xs-12 col-sm-6 noppading _main-card" <?php echo $style; ?>>
					<?php elseif ($grid == "secondary") : ?>
					<div name="card_<?php echo $i; ?>" class="_main-card col-xs-12 col-sm-6 noppading _secondary-card" <?php echo $style; ?>>
					<?php endif; ?>
					    <section class="container-fluid main-card">
					        <header class="row header-container">
					            <div class="image-container nopadding col-xs-12">
					                <img class="img-responsive" src="<?php echo $imagen; ?>" alt="<?php echo $imagen_alt; ?>">
					            </div>
					            <div class="hidden-xs floating-text col-xs-9">
					                <p class="date"><?php echo $post_date; ?></p>
					                <h1><?php echo $post_title; ?></h1>
					            </div>
					        </header>
					        <div class="row data-container">
					            <p class="nopadding col-xs-9 date"><?php echo $post_date; ?></p>
					            <h1 class="title nopadding col-xs-9"><?php echo $post_title; ?></h1>
					            <p><?php echo $post_content; ?>.</p>
					            <a href="<?php echo $enlace_detalle; ?>" class="hidden-xs readmore"><?php _e("Leer más", "os_cards_widget"); ?></a>
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
					</div>
	                <?php $i++; ?>
	            	<?php endforeach; ?>
	            </div>
	        </div>
	        <footer class="grid-footer">
	            <div class="row">
	                <div class="col-md-12 text-center">
	                    <a href="<?php echo $enlace_detalle; ?>" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e("Todas las historias", "os_cards_widget"); ?></a>
	                </div>
	            </div>
	        </footer>
	    	<?php endif; ?>
	    </div>
	</section>
	<?php
}
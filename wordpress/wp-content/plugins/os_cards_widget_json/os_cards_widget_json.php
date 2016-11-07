<?php

/*
	Plugin Name: OS Cards Widget Json
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra tarjetas para distintos tipos de posts a partir de un json.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_cards_widget_json
*/


if (!class_exists('OS_Cards_Widget_Json')) :

	class OS_Cards_Widget_Json extends WP_Widget {

		// Constructor
	    function __construct() {
	        parent::__construct(
	        	'os_cards_widget_json',
	        	__('Tarjetas de publicaciones/historias', 'os_cards_widget_json'),
	        	array(
	            	'description' => __('Muestra tarjetas para distintos tipos de posts a partir de un json.', 'os_cards_widget_json')
	        	)
	        );
			wp_register_script('os_cards_widget_json_js', plugins_url('js/os_cards_widget_json.js' , __FILE__), array('jquery'));

			$locale = 'es_ES';
			if (function_exists('get_locale')) {
				$locale = get_locale();
			}


			$translation_array = array(
				'leer_mas' => __('Leer más', 'os_cards_widget_json'),
				'enero' => __('Enero', 'os_cards_widget_json'),
				'febrero' => __('Febrero', 'os_cards_widget_json'),
				'marzo' => __('Marzo', 'os_cards_widget_json'),
				'abril' => __('Abril', 'os_cards_widget_json'),
				'mayo' => __('Mayo', 'os_cards_widget_json'),
				'junio' => __('Junio', 'os_cards_widget_json'),
				'julio' => __('Julio', 'os_cards_widget_json'),
				'agosto' => __('Agosto', 'os_cards_widget_json'),
				'septiembre' => __('Septiembre', 'os_cards_widget_json'),
				'octubre' => __('Octubre', 'os_cards_widget_json'),
				'noviembre' => __('Noviembre', 'os_cards_widget_json'),
				'diciembre' => __('Diciembre', 'os_cards_widget_json'),
				'locale' => $locale,
			);
			wp_localize_script('os_cards_widget_json_js', 'object_name_cards', $translation_array);
			wp_enqueue_script('os_cards_widget_json_js');
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
	    	$orden = (!empty($instance['orden_posts'])) ? $instance['orden_posts'] : 'DESC';

	    	$parts = parse_url($_SERVER['REQUEST_URI']);
	    	$author_name = '';
			if (preg_match("/perfiles\/(\S+)/", $parts['path'], $match)) {
			    $author_name = str_replace('/', '', $match[1]);
			}

	    	$author = isset($instance['filtrar_por_autor']) ? $author_name : '';

	    	if (empty($author)) {
	    		if ($tipo_post == "publicacion") {
	    			if ($orden == 'DESTACADOS') {
			    		$args = array(
							'posts_per_page'   => $numero_posts_mostrar,
							'offset'           => 0,
							'orderby'          => 'post_date',
							'meta_key' 		   => 'publication_date', 
							'order'            => 'DESC',
							'orderby' 		   => 'meta_value',
							'post_type'        => $tipo_post,
							'post_status'      => 'publish',
							'suppress_filters' => false,
							'meta_query' => array(
						        array(
									'key'         => 'destacada',
									'value'       => 'on',
									'compare'     => '=',
						        ),
						    )
						);
	    			} else {
			    		$args = array(
							'posts_per_page'   => $numero_posts_mostrar,
							'offset'           => 0,
							'orderby'          => 'post_date',
							'meta_key' 		   => 'publication_date', 
							'order'            => 'DESC',
							'orderby' 		   => 'meta_value',
							'post_type'        => $tipo_post,
							'post_status'      => 'publish',
							'suppress_filters' => false
						);
	    			}
	    		} else {
	    			if ($orden == 'DESTACADOS') {
		    			$args = array(
							'posts_per_page'   => $numero_posts_mostrar,
							'offset'           => 0,
							'category'         => '',
							'orderby'          => 'post_date',
							'order'            => 'DESC',
							'meta_key'         => '',
							'meta_value'       => '',
							'post_type'        => $tipo_post,
							'post_status'      => 'publish',
							'suppress_filters' => false,
							'meta_query' => array(
						        array(
									'key'         => 'destacada',
									'value'       => 'on',
									'compare'     => '=',
						        ),
						    )
						);
	    			} else {
		    			$args = array(
							'posts_per_page'   => $numero_posts_mostrar,
							'offset'           => 0,
							'category'         => '',
							'orderby'          => 'post_date',
							'order'            => 'DESC',
							'meta_key'         => '',
							'meta_value'       => '',
							'post_type'        => $tipo_post,
							'post_status'      => 'publish',
							'suppress_filters' => false
						);
	    			}
	    		}

		    	$posts = get_posts($args);
	    	
	    	} 
	    	else {
	    		
	    		$posts = query_posts("posts_per_page=" . $numero_posts_mostrar . "&post_status=publish&post_type=" . $tipo_post . "&author_name=" . $author . "&order=" . $orden);
	    	}


	    	switch ($plantilla) {
	    		case 'plantilla_1' :
	    			imprime_plantilla_1_json($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle, $tipo_post, $orden);
	    			break;
	    		case 'plantilla_2' :
	    			if (!empty($posts))
	    				imprime_plantilla_2_json($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle, $tipo_post, $orden, $author_name);
	    			break;
	    		case 'plantilla_3' :
	    			imprime_plantilla_3_json($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle, $tipo_post, $orden);
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
	    	$orden = (!empty($instance["orden_posts"])) ? $instance["orden_posts"] : "";
	    	
	    	?>	
	    	<p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título', 'os_cards_widget_json'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto', 'os_cards_widget_json'); ?>:</label>
				<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>" type="text"><?php echo esc_attr($texto); ?></textarea>
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('numero_posts_mostrar'); ?>"><?php _e('Número de posts a mostrar inicialmente', 'os_cards_widget_json'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('numero_posts_mostrar'); ?>" name="<?php echo $this->get_field_name('numero_posts_mostrar'); ?>" type="number" value="<?php echo esc_attr($numero_posts_mostrar); ?>">
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('numero_posts_totales'); ?>"><?php _e('Número de posts a mostrar al pulsar ver más', 'os_cards_widget_json'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('numero_posts_totales'); ?>" name="<?php echo $this->get_field_name('numero_posts_totales'); ?>" type="number" value="<?php echo esc_attr($numero_posts_totales); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('tipo_post'); ?>"><?php _e('Tipo de post', 'os_cards_widget_json'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('tipo_post'); ?>" name="<?php echo $this->get_field_name('tipo_post'); ?>">
					<option value="publicacion" <?php $selected = ($tipo_post == 'publicacion') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Publicación', 'os_cards_widget_json'); ?></option>
					<option value="historia" <?php $selected = ($tipo_post == 'historia') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Historia', 'os_cards_widget_json'); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('plantilla'); ?>"><?php _e('Plantilla para mostrar', 'os_cards_widget_json'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('plantilla'); ?>" name="<?php echo $this->get_field_name('plantilla'); ?>">
					<option value="plantilla_1" <?php $selected = ($plantilla == 'plantilla_1') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('3 posts en cada línea', 'os_cards_widget_json'); ?></option>
					<option value="plantilla_2" <?php $selected = ($plantilla == 'plantilla_2') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('2 posts en una línea, 3 en otra', 'os_cards_widget_json'); ?></option>
					<option value="plantilla_3" <?php $selected = ($plantilla == 'plantilla_3') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('1 post a la izquierda, 2 posts a la derecha', 'os_cards_widget_json'); ?></option>
				</select>
			</p>
	    	<p>
				<label for="<?php echo $this->get_field_id('enlace_detalle'); ?>"><?php _e('Enlace a detalle', 'os_cards_widget_json'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('enlace_detalle'); ?>" name="<?php echo $this->get_field_name('enlace_detalle'); ?>" type="url" value="<?php echo esc_attr($enlace_detalle); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('orden_posts'); ?>"><?php _e('Orden de los posts', 'os_cards_widget_json'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('orden_posts'); ?>" name="<?php echo $this->get_field_name('orden_posts'); ?>">
					<option value="ASC" <?php $selected = ($orden == 'ASC') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Ascendente', 'os_cards_widget_json'); ?></option>
					<option value="DESC" <?php $selected = ($orden == 'DESC') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Descendente', 'os_cards_widget_json'); ?></option>
					<option value="DESTACADOS" <?php $selected = ($orden == 'DESTACADOS') ? 'selected="selected"' : ''; echo $selected; ?>><?php _e('Destacados', 'os_cards_widget_json'); ?></option>
				</select>
			</p>
			<p>
				<input class="widefat" id="<?php echo $this->get_field_id('filtrar_por_autor'); ?>" name="<?php echo $this->get_field_name('filtrar_por_autor'); ?>" type="checkbox" <?php checked($instance['filtrar_por_autor'], 'on'); ?>>
				<label for="<?php echo $this->get_field_id('filtrar_por_autor'); ?>"><?php _e('Filtrar por autor', 'os_cards_widget_json'); ?></label>
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
	    	$instance['orden_posts'] = (!empty($new_instance['orden_posts'])) ? strip_tags($new_instance['orden_posts']) : "DESC";

			return $instance;
	    }

	}


	// Registrar el widget
	function os_cards_widget_json() {
	    register_widget('os_cards_widget_json');
	}

	
	// Inicializar el widget
	add_action('widgets_init', 'os_cards_widget_json');


endif;


// 3 posts en cada linea
function imprime_plantilla_1_json($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle, $tipo_post, $orden) {

	if (count($posts) < $numero_posts_mostrar) {
		$numero_posts_mostrar = count($posts);
	}

	$count_posts = wp_count_posts($tipo_post);
	$published_posts = $count_posts->publish;

	if (empty($enlace_detalle)) : ?>
		<input type="hidden" id="tipo" name="tipo" value="<?php echo $tipo_post; ?>">
		<input type="hidden" id="orden" name="orden" value="<?php echo $orden; ?>">
		<input type="hidden" id="npv" name="npv" value="<?php echo $numero_posts_totales; ?>">
		<input type="hidden" id="npt" name="npt" value="<?php echo $numero_posts_mostrar; ?>">
		<input type="hidden" id="npc" name="npc" value="<?php echo $numero_posts_mostrar; ?>">
		<input type="hidden" id="plantilla" name="plantilla" value="plantilla_2">
	<?php endif; ?>

	<section class="latests-posts pt-xl wow fadeInUp">
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
                	<?php for ($i = 0; $i < $numero_posts_mostrar; $i++) : ?>

                		<?php

                			$post_title = $posts[$i]->post_title;

                			$post_type = $posts[$i]->post_type;
                			if ($post_type == 'publicacion') {
                				$fecha_publicacion = get_post_meta($posts[$i]->ID, 'publication_date', true);
                				$post_date = get_fecha_formateada($fecha_publicacion);
                			} else {
                				$post_date = get_the_date('j F Y', $posts[$i]->ID);
                			}

                			$post_guid = get_permalink($posts[$i]->ID);
                			$post_abstract = substr(get_post_meta($posts[$i]->ID, 'abstract_destacado', true), 0, 140) . '...';
                			$pdf = get_post_meta($posts[$i]->ID, 'pdf', true);
                			$imagen = get_post_meta($posts[$i]->ID, 'imagenCard', true);

                			$videoIntro_url = get_post_meta($posts[$i]->ID, 'videoIntro-url', true);
       					
       					?>
       					<?php $j = $i + 1; ?>
       					<?php if ($i !== 0 && $i % 2 == 0) : ?>
       						<div class="<?php echo $j; ?> main-card-container col-xs-12  col-lg-4  hidden-sm hidden-md  noppading">
       					<?php else : ?>
       						<div class="<?php echo $j; ?> main-card-container col-xs-12  col-lg-4  col-sm-6 col-md-6  noppading">
						<?php endif; ?>
		                    <section class="container-fluid main-card">
		                        <header class="row header-container">
		                            <div class="image-container nopadding col-xs-12">
		                            	<a href="<?php echo $post_guid; ?>" class="link-header-layer visible-xs">
		                            		<img src="<?php echo $imagen; ?>" alt="" />
		                            	</a>
		                            	<img src="<?php echo $imagen; ?>" alt="" class="hidden-xs" />
		                            </div>
		                            <div class="hidden-xs floating-text col-xs-9">
		                                <p class="date"><?php echo $post_date; ?></p>
		                                <h1><?php echo $post_title; ?></h1>
		                            </div>
		                        </header>
		                        <div class="row data-container">
		                            <div class="nopadding date"><?php echo $post_date; ?></div>
		                            <div class="main-card-data-container-title-wrapper">
		                            	<h1 class="title nopadding"><?php echo $post_title; ?></h1>
		                            </div>
		                            <p class="main-card-data-container-description-wrapper"><?php echo $post_abstract; ?></p>
		                            <a href="<?php echo $post_guid; ?>" class="hidden-xs mb-xs readmore"><?php _e("Leer más", "os_cards_widget_json"); ?></a>
                                    <footer>
                                        <div class="icon-row">
                                        	<?php if (false) : ?>
                                            <div class="card-icon"><span class="icon bbva-icon-quote2"></span>
                                                <div class="triangle triangle-up-left"></div>
                                                <div class="triangle triangle-down-right"></div>
                                            </div>
                                            <?php endif; ?>
                                        	<?php if (!empty($videoIntro_url)) :?>
	                                            <div class="card-icon"><span class="icon bbva-icon-audio2"></span>
	                                                <div class="triangle triangle-up-left"></div>
	                                                <div class="triangle triangle-down-right"></div>
	                                            </div>
	                                        <?php endif; ?>
	                                        <?php if (false) : ?>
	                                            <div class="card-icon"><span class="icon bbva-icon-chat2"></span>
	                                                <div class="triangle triangle-up-left"></div>
	                                                <div class="triangle triangle-down-right"></div>
	                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </footer>
		                        </div>
		                    </section>
	                    </div>
	                <?php endfor; ?>
	            </div>
	        </section>
	        <footer class="grid-footer">
	            <div class="row">
	                <div class="col-md-12 text-center">
	                     <a <?php if ($numero_posts_mostrar >= $published_posts) echo 'style="display: none;"';?> href="<?php echo $enlace_detalle; ?>" <?php if (empty($enlace_detalle)) : echo 'id="readmore"'; endif; ?> class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span> <?php _e('Todas las publicaciones', 'os_cards_widget_json'); ?></a>
	                </div>
	            </div>
	        </footer>
	    	<?php endif; ?>
	    </div>
	</section>
	<?php
}


// 2 posts en una linea, 3 en otra
function imprime_plantilla_2_json($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle, $tipo_post, $orden, $author_name) {
	
	if (count($posts) < $numero_posts_mostrar) {
		$numero_posts_mostrar = count($posts);
	}

	$count_posts = wp_count_posts($tipo_post);

	if (empty($author_name)) {
		$published_posts = count(query_posts("post_status=publish&post_type=publicacion&author_name=" . $author_name));
	} else {
		$published_posts = $count_posts->publish;
	}

	if (empty($enlace_detalle)) : ?>
		<input type="hidden" id="tipo" name="tipo" value="<?php echo $tipo_post; ?>">
		<?php if (empty($author_name)) : ?>
			<input type="hidden" id="orden" name="orden" value="<?php echo $orden; ?>">
		<?php else : ?>
			<input type="hidden" id="orden" name="orden" value="<?php echo 'AUTOR_'. $author_name; ?>">
		<?php endif; ?>	
		<input type="hidden" id="npv" name="npv" value="<?php echo $numero_posts_totales; ?>">
		<input type="hidden" id="npt" name="npt" value="<?php echo $numero_posts_mostrar; ?>">
		<input type="hidden" id="npc" name="npc" value="<?php echo $numero_posts_mostrar; ?>">
		<input type="hidden" id="plantilla" name="plantilla" value="plantilla_2">
	<?php endif; ?>

	<div id="search-layer"></div>
	<article id="publishing-view">
	    <div class="main-wrapper">
	        <header class="container">
	            <h1><?php echo $titulo; ?></h1>
	            <h2><?php echo $texto; ?></h2>
	            <?php if (empty($author_name)) { imprime_links_ordenacion($orden); the_widget('os_filtro_widget', array()); } ?>
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
									
									$post_type = $posts[$i]->post_type;
									if ($post_type == 'publicacion') {
										$fecha_publicacion = get_post_meta($posts[$i]->ID, 'publication_date', true);
										$post_date = get_fecha_formateada($fecha_publicacion);
									} else {
										$post_date = get_the_date('j F Y', $posts[$i]->ID);
									}
	                    			
	                    			$post_guid = get_permalink($post->ID);
	                    			$post_abstract = get_post_meta($post->ID, 'abstract_destacado', true);
	                    			$pdf = get_post_meta($post->ID, 'pdf', true);
			            			$imagen = get_post_meta($post->ID, 'imagenCard', true);

			            			$videoIntro_url = get_post_meta($post->ID, 'videoIntro-url', true);
	                    		?>

	           					<?php $grid = $order[($i % 5)]; ?>
	           					<?php if ($grid == "double") : ?>
	           						<div class="col-xs-12 col-sm-6 double-card card-container">
	           					<?php elseif ($grid == "triple") : ?>
	           						<div class="col-xs-12 col-sm-4 triple-card card-container">
	           					<?php endif; ?>
								    <section class="container-fluid main-card">
								        <header class="row header-container">
								            <div class="image-container col-xs-12">
								                <a href="<?php echo $post_guid; ?>" class="link-header-layer visible-xs"><img src="<?php echo $imagen; ?>" alt="" /></a>
								                <img src="<?php echo $imagen; ?>" alt="" class="hidden-xs" />
								            </div>
								            <div class="hidden-xs floating-text col-xs-9">
								                <p class="date"><?php echo $post_date; ?></p>
								                <h1><?php echo $post_title; ?></h1>
								            </div>
								        </header>
								        <div class="row data-container">
								        	<a href="#" class="link-layer visible-xs">&nbsp;</a>
								            <div class="nopadding date"><?php echo $post_date; ?></div>
								            <div class="main-card-data-container-title-wrapper">
								            	<h1 class="title nopadding"><?php echo $post_title; ?></h1>
								            </div>
								            <p class="main-card-data-container-description-wrapper"><?php echo strip_tags($post_abstract); ?></p>
								            <a href="<?php echo $post_guid; ?>" class="hidden-xs mb-xs readmore"><?php _e('Leer más', 'os_cards_widget_json'); ?></a>
		                                    <footer>
		                                        <div class="icon-row">
		                                        	<?php if (false) : ?>
			                                            <div class="card-icon"><span class="icon bbva-icon-quote2"></span>
			                                                <div class="triangle triangle-up-left"></div>
			                                                <div class="triangle triangle-down-right"></div>
			                                            </div>
		                                        	<?php endif; ?>
		                                        	<?php if (!empty($videoIntro_url)) :?>
			                                            <div class="card-icon"><span class="icon bbva-icon-audio2"></span>
			                                                <div class="triangle triangle-up-left"></div>
			                                                <div class="triangle triangle-down-right"></div>
			                                            </div>
			                                        <?php endif; ?>
			                                        <?php if (false) : ?>
			                                            <div class="card-icon"><span class="icon bbva-icon-chat2"></span>
			                                                <div class="triangle triangle-up-left"></div>
			                                                <div class="triangle triangle-down-right"></div>
			                                            </div>
			                                        <?php endif; ?>
		                                        </div>
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
	                                <a <?php if ($numero_posts_mostrar >= $published_posts) echo 'style="display: none;"';?> href="<?php echo $enlace_detalle; ?>" <?php if (empty($enlace_detalle)) : echo 'id="readmore"'; endif; ?> class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span> <?php _e('Más publicaciones', 'os_cards_widget_json'); ?></a>
	                            </div>
	                        </div>
	                    </footer>
	                </section>
	            </article>
	        </section>
	    	<?php endif; ?>
	    </div>
	</article>
	<?php if (empty($author_name)): ?>
		<?php imprimir_json_etiquetas(); ?>
		<div class="filter-mobile closed hidden-sm hidden-md hidden-lg">
		    <div class="container">
		        <div class="close-filter-mobile">
		            <span class="bbva-icon-close"></span>
		        </div>
		        <section class="content">
		            <div id="publishing-filter-mobile" class="publishing-filter-wrapper-mobile">
		                <header>
		                    <input type="text" class="publishing-filter-search-input form-control" name="publishing-filter-search-input">
		                    <div class="selected-tags-container"></div>
		                    <div class="button-filter">
		                        <a href="#" class="btn-bbva-aqua publishing-filter-search-btn" type="button" name="publishing-filter-search-btn"><?php _e('Filtrar', 'os_filtro_widget'); ?></a>
		                    </div>
		                </header>
		                <section>
		                    <div class="row available-tags-wrapper">
		                        <div class="col-xs-12">
		                            <p class="text-capitalize column-name"><?php _e('tags', 'os_filtro_widget'); ?> (<span class="tag-container-counter">0</span>)</p>
		                            <div class="tag-container">
		                            </div>
		                        </div>
		                        <div class="col-xs-12">
		                            <p class="text-capitalize column-name"><?php _e('Autores', 'os_filtro_widget'); ?> (<span class="author-container-counter">0</span>)</p>
		                            <div class="author-container">
		                            </div>
		                        </div>
		                        <div class="col-xs-12">
		                            <p class="text-capitalize column-name"><?php _e('ámbito geográfico', 'os_filtro_widget'); ?> (<span class="geo-container-counter">0</span>)</p>
		                            <div class="geo-container">
		                            </div>
		                        </div>
		                    </div>
		                </section>
		            </div>
		        </section>
		    </div>
		</div>
	<?php endif; ?>
	<?php
}


// 1 post a la izquierda, 2 posts a la derecha
function imprime_plantilla_3_json($titulo, $texto, $posts, $numero_posts_totales, $numero_posts_mostrar, $enlace_detalle, $tipo_post, $orden) {
	
	if (count($posts) < $numero_posts_mostrar) {
		$numero_posts_mostrar = count($posts);
	}

	$count_posts = wp_count_posts($tipo_post);
	$published_posts = $count_posts->publish;

	if (empty($enlace_detalle)) : ?>
		<input type="hidden" id="tipo" name="tipo" value="<?php echo $tipo_post; ?>">
		<input type="hidden" id="orden" name="orden" value="<?php echo $orden; ?>">
		<input type="hidden" id="npv" name="npv" value="<?php echo $numero_posts_totales; ?>">
		<input type="hidden" id="npt" name="npt" value="<?php echo $numero_posts_mostrar; ?>">
		<input type="hidden" id="npc" name="npc" value="<?php echo $numero_posts_mostrar; ?>">
		<input type="hidden" id="plantilla" name="plantilla" value="plantilla_2">
	<?php endif; ?>
	
	<section class="outstanding-histories pt-xl wow fadeInUp">
	    <div class="container">
	        <header class="title-description">
	            <h1><?php echo $titulo; ?></h1>
	            <div class="description-container">
	                <p><?php echo $texto; ?></p>
	            </div>
	        </header>
	        
	        <?php if (!empty($posts)) : ?>
	        <div class="card-container container-fluid mt-md mb-md">
	            <div class="row">
	            	<?php $order = array("main", "secondary", "secondary"); ?>
	            	<?php $i = 0; ?>
	                <?php foreach ($posts as $post) : ?>
	                	<?php

                	        $post_title = $post->post_title;
                	        if (strlen($post_title) > 38) {
								$post_title = substr($post_title,0,38) . "...";
							}

							$post_type = $posts[$i]->post_type;
							if ($post_type == 'publicacion') {
								$fecha_publicacion = get_post_meta($posts[$i]->ID, 'publication_date', true);
								$post_date = get_fecha_formateada($fecha_publicacion);
							} else {
								$post_date = get_the_date('j F Y', $posts[$i]->ID);
							}

                			$post_guid = get_permalink($post->ID);
                			$post_content = substr($post->post_content, 0, 140) . '...';
	            			$imagen = get_post_meta($post->ID, 'imagenCard', true);

	            			$videoIntro_url = get_post_meta($post->ID,'videoIntro-url',true);

       						$style = '';
       						if (empty($enlace_detalle) && $i >= $numero_posts_mostrar) 
       							$style = 'style="display: none;';

       						$subtitulo = get_post_meta($post->ID,'subtitulo',true);
    						$texto_destacado = get_post_meta($post->ID,'texto-destacado',true);


	                	?>
	                	<?php $grid = $order[$i % 3]; ?>
	                	<?php if ($grid == "main") : ?>
	                		<div class="_main-card col-xs-12 col-sm-6 noppading _main-card">
	                	<?php elseif ($grid == "secondary") : ?>
	                		<div class="_main-card col-xs-12 col-sm-6 noppading _secondary-card">
	                	<?php endif; ?>
			                    <section class="container-fluid main-card">
			                        <header class="row header-container">
							            <div class="image-container col-xs-12">
							                <a href="<?php echo $post_guid; ?>" class="link-header-layer visible-xs">
							                    <img src="<?php echo $imagen; ?>" alt="" />
							                </a>
							                <img src="<?php echo $imagen; ?>" alt="" class="hidden-xs" />
							            </div>
			                            <div class="hidden-xs floating-text col-xs-9">
			                                <p class="date"><?php echo $post_date; ?></p>
			                                <h1><?php echo $post_title; ?></h1>
			                            </div>
			                        </header>
			                        <div class="row data-container">
			                        	<a href="<?php echo $post_guid; ?>" class="link-layer visible-xs">&nbsp;</a>
			                            <div class="nopadding date"><?php echo $post_date; ?></div>
			                            <div class="main-card-data-container-title-wrapper">
			                            	<h1 class="title nopadding"><?php echo $post_title; ?></h1>
			                            </div>
			                            <p class="main-card-data-container-description-wrapper"><?php echo $texto_destacado; ?></p>
			                            <a href="<?php echo $post_guid; ?>" class="hidden-xs mb-xs readmore"><?php _e("Leer más", "os_cards_widget_json"); ?></a>
                                        <footer>
                                            <div class="icon-row">
                                            	<?php if (false) : ?>
	                                                <div class="card-icon"><span class="icon bbva-icon-quote2"></span>
	                                                    <div class="triangle triangle-up-left"></div>
	                                                    <div class="triangle triangle-down-right"></div>
	                                                </div>
                                                <?php endif; ?>
                                                <?php if (!empty($videoIntro_url)) : ?>
	                                                <div class="card-icon"><span class="icon bbva-icon-audio2"></span>
	                                                    <div class="triangle triangle-up-left"></div>
	                                                    <div class="triangle triangle-down-right"></div>
	                                                </div>
	                                            <?php endif; ?>
	                                            <?php if (false) : ?>
	                                                <div class="card-icon"><span class="icon bbva-icon-chat2"></span>
	                                                    <div class="triangle triangle-up-left"></div>
	                                                    <div class="triangle triangle-down-right"></div>
	                                                </div>
	                                            <?php endif; ?>
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
	                    <a <?php if ($numero_posts_mostrar >= $published_posts) echo 'style="display: none;"';?> href="<?php echo $enlace_detalle; ?>" <?php if (empty($enlace_detalle)) : echo 'id="readmore"'; endif; ?> class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e("Todas las Historias", "os_cards_widget_json");?></a>
	                </div>
	            </div>
	        </footer>
	    	<?php endif; ?>
	    </div>
	</section>
	<?php
}


function imprime_links_ordenacion($orden) {
	?>
    <div class="visible-xs mobile-filter filter-mobile-button">
        <a href="#"><span class="bbva-icon-filter"></span> <?php _e('filtrar', 'os_cards_widget_json'); ?></a>
    </div>
    <div class="sort-items-container">
        <a data-order-filter="date desc" data-order="DESC" class="<?php if ($orden == 'DESC') echo 'selected';?>" href="" class="selected">
            <span class="icon bbva-icon-arrow arrow arrowUp"></span>
            <span class="text"><?php _e('Más recientes', 'os_cards_widget_json'); ?></span>
        </a>
        <a data-order-filter="date asc" data-order="ASC" class="<?php if ($orden == 'ASC') echo 'selected';?>" href="" class="">
            <span class="icon bbva-icon-arrow arrow arrowDown"></span>
            <span class="text"><?php _e('Más antiguos', 'os_cards_widget_json'); ?></span>
        </a>
        <a data-order-filter="destacados" data-order="DESTACADOS" class="<?php if ($orden == 'DESTACADOS') echo 'selected';?>" href="" class="">
            <span class="icon bbva-icon-view extra-space "></span>
            <span class="text"><?php _e('Más leídos', 'os_cards_widget_json'); ?></span>
        </a>
    </div>
	<?php
}
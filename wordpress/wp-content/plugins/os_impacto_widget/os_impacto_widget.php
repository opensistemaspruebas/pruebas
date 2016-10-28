<?php

/*
	Plugin Name: OS Impactos Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget con los impactos seleccionados
	Version: 1.0
	Author: Roberto Moreno
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_impactos_widget
*/


if (!class_exists('OS_Impactos_Widget')) :

	class OS_Impactos_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_impactos_widget',
	        	__('OS Impactos Widget', 'os_impactos_widget'),
	        	array(
	            	'description' => __('Widget con los impactos seleccionados.', 'os_impactos_widget')
	        	)
	        );
	        add_action('admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));
        }


	    public function widget($args, $instance) {
	    	
	    	global $wpdb;

	    	$title = $instance['title'];
	    	$texto = $instance['texto'];
	    	$tipo_widget = $instance['tipo_widget'];
	    	$tipo_impactos = $instance['tipo_impactos'];
	    	$subhome_impactos = $instance['subhome_impactos'];
	    	$impacto_1_circulo = $instance['impacto_1_circulo'];
	    	$impacto_2_circulo = $instance['impacto_2_circulo'];
	    	$impacto_3_circulo = $instance['impacto_3_circulo'];	
	    	$impacto_1_barra = $instance['impacto_1_barra'];
	    	$impacto_2_barra = $instance['impacto_2_barra'];
	    	$impacto_1_dato = $instance['impacto_1_dato'];
	    	$impacto_2_dato = $instance['impacto_2_dato'];
	    	$impacto_3_dato = $instance['impacto_3_dato'];



	    		if($tipo_widget == 'widgetHome'){

	    			$query = new WP_Query(
		        		array(
		        			'post_type' => 'impacto', 
		        			'post__in' => array($impacto_1_circulo, $impacto_2_circulo, $impacto_3_circulo),
		        			'orderby' => 'post__in'
		        		)
		        	);


		        	if ($query->have_posts()) {

						$widgetId = $args['widget_id'];
		        		$identificadores = array($widgetId.'a',$widgetId.'b',$widgetId.'c');
						$i = 0;

			?>


						<section class="home-impact pt-xl">
			                <div class="container">
			                    <header class="title-description">
			                        <h1><?php echo $title; ?></h1>
			                        <div class="description-container">
			                            <p><?php echo $texto; ?></p>
			                        </div>
			                    </header>
			                    <div class="row">


			<?php

						while ($query->have_posts()) : $query->the_post();

							$identificador = $identificadores[$i];

							$post_id = get_the_id();
							$visualizacion = (get_post_meta($post_id, 'visualizacion', true)) ? get_post_meta($post_id, 'visualizacion', true) : "circulo";
							$color_circulo = get_post_meta($post_id, 'color_circulo', true);
							$etiqueta = mb_strtoupper(get_post_meta($post_id, 'etiqueta', true), 'UTF-8');
							$objetivo = get_post_meta($post_id, 'objetivo', true);
							$completado = get_post_meta($post_id, 'completado', true);
			
							pintaWidgetHomeCirculos($etiqueta, $color_circulo, $objetivo, $completado, $identificador);


							$i++;
						endwhile;

						wp_reset_postdata();
					} 
					else {
				
						_e("No hay impactos disponibles.", "os_impactos_widget");
					}

			?>

								</div>
			                    <div class="btn-container text-center">
			                        <a href="<?php echo get_permalink($subhome_impactos); ?>" class="btn btn-bbva-aqua"><?php _e("Ver impactos", "os_impactos_widget"); ?></a>
			                    </div>
			                </div>
			            </section>

	    	<?php

	    		}
	    		else if (($tipo_widget == 'widgetSubhomeIntroduccion') || ($tipo_widget == 'widgetSubhomeSecundario')){

	    			switch($tipo_impactos){

	    				case 'circulo':{

	    					$query = new WP_Query(
				        		array(
				        			'post_type' => 'impacto', 
				        			'post__in' => array($impacto_1_circulo, $impacto_2_circulo, $impacto_3_circulo),
				        			'orderby' => 'post__in'
				        		)
				        	);


				        	if ($query->have_posts()) {

								$widgetId = $args['widget_id'];
				        		$identificadores = array($widgetId.'d',$widgetId.'e',$widgetId.'f');
								$i = 0;

		    					if ($tipo_widget == 'widgetSubhomeIntroduccion'){ 

		    	?>

		    						 
 										<div class="impact container">
            								 <section class="impact-section">
							                    <h1><?php echo $title; ?></h1>
							                    <p class="initial-description"><?php echo $texto; ?></p>
						                    </section>
						                    <section class="beneficiaries-section">
						                    	<div class="row">
                									<section class="beneficiaries-section pt-lg">

				<?php

						            while ($query->have_posts()) : $query->the_post();

										$identificador = $identificadores[$i];

										$post_id = get_the_id();
										$visualizacion = (get_post_meta($post_id, 'visualizacion', true)) ? get_post_meta($post_id, 'visualizacion', true) : "circulo";
										$color_circulo = get_post_meta($post_id, 'color_circulo', true);
										$etiqueta = mb_strtoupper(get_post_meta($post_id, 'etiqueta', true), 'UTF-8');
										$objetivo = get_post_meta($post_id, 'objetivo', true);
										$completado = get_post_meta($post_id, 'completado', true);
						
										pintaWidgetCirculos($etiqueta, $color_circulo, $objetivo, $completado, $identificador);


										$i++;
									endwhile;

									wp_reset_postdata();

				?>
				 									</section>
									        	</div>
											</section>
										</div>
				<?php

		    					}
		    					else if($tipo_widget == 'widgetSubhomeSecundario'){

		    	?>				
		    							<div class="impact container">
			    							<section class="beneficiaries-section">
							                    <h1><?php echo $title; ?></h1>
							                    <p class="mb-xl"><?php echo $texto; ?></p>							             							              
						                    	<div class="row">       
                <?php        


	                				while ($query->have_posts()) : $query->the_post();

											$identificador = $identificadores[$i];

											$post_id = get_the_id();
											$visualizacion = (get_post_meta($post_id, 'visualizacion', true)) ? get_post_meta($post_id, 'visualizacion', true) : "circulo";
											$color_circulo = get_post_meta($post_id, 'color_circulo', true);
											$etiqueta = mb_strtoupper(get_post_meta($post_id, 'etiqueta', true), 'UTF-8');
											$objetivo = get_post_meta($post_id, 'objetivo', true);
											$completado = get_post_meta($post_id, 'completado', true);
							
											pintaWidgetCirculos($etiqueta, $color_circulo, $objetivo, $completado, $identificador);


											$i++;
										endwhile;

										wp_reset_postdata();

				?>
									        	</div>
											</section>
										</div>
				<?php
		    					}

		    				}
		    				else {
				
								_e("No hay impactos disponibles.", "os_impactos_widget");
							}

	    				}break;



	    				case 'barra':{

	    					$query = new WP_Query(
				        		array(
				        			'post_type' => 'impacto', 
				        			'post__in' => array($impacto_1_barra, $impacto_2_barra),
				        			'orderby' => 'post__in'
				        		)
				        	);


				        	if ($query->have_posts()) {

								$widgetId = $args['widget_id'];
				        		$identificadores = array($widgetId.'g',$widgetId.'h',$widgetId.'i');
								$i = 0;

				        		    					
					        	if ($tipo_widget == 'widgetSubhomeIntroduccion'){


				?>						 
									<div class="impact container">
	    								 <section class="impact-section">
						                    <h1><?php echo $title; ?></h1>
						                    <p class="initial-description"><?php echo $texto; ?></p>
						                    <div class="row">					                 
				<?php

								    while ($query->have_posts()) : $query->the_post();

											$identificador = $identificadores[$i];

											$post_id = get_the_id();
											$visualizacion = (get_post_meta($post_id, 'visualizacion', true)) ? get_post_meta($post_id, 'visualizacion', true) : "circulo";
											$etiqueta = mb_strtoupper(get_post_meta($post_id, 'etiqueta', true), 'UTF-8');
											$objetivo = get_post_meta($post_id, 'objetivo', true);
											$completado = get_post_meta($post_id, 'completado', true);
							
											pintaWidgetBarras($etiqueta, $objetivo, $completado, $identificador);

											$i++;
										endwhile;

										wp_reset_postdata();


				?>
									        </div>
										</section>
									</div>
				<?php

		    					}
		    					else if($tipo_widget == 'widgetSubhomeSecundario'){

		    	?>						 
									<div class="impact container">
	    								<section class="beneficiaries-section">
						                    <h1><?php echo $title; ?></h1>
						                    <p class="mb-xl"><?php echo $texto; ?></p>
						                </section>
						                <section class="impact-section">
						                    <div class="row">					                 
				<?php

									 while ($query->have_posts()) : $query->the_post();

											$identificador = $identificadores[$i];

											$post_id = get_the_id();
											$visualizacion = (get_post_meta($post_id, 'visualizacion', true)) ? get_post_meta($post_id, 'visualizacion', true) : "circulo";
											$etiqueta = mb_strtoupper(get_post_meta($post_id, 'etiqueta', true), 'UTF-8');
											$objetivo = get_post_meta($post_id, 'objetivo', true);
											$completado = get_post_meta($post_id, 'completado', true);
							
											pintaWidgetBarras($etiqueta, $objetivo, $completado, $identificador);

											$i++;
										endwhile;

										wp_reset_postdata();

				?>
									        </div>
										</section>
									</div>
				<?php

		    					}
							}
							else {
				
								_e("No hay impactos disponibles.", "os_impactos_widget");
							}
	    				}break;







	    				case 'dato':{

	    					$query = new WP_Query(
				        		array(
				        			'post_type' => 'impacto', 
				        			'post__in' => array($impacto_1_dato, $impacto_2_dato, $impacto_3_dato),
				        			'orderby' => 'post__in'
				        		)
				        	);


				        	if ($query->have_posts()) {

								$widgetId = $args['widget_id'];
				        		$identificadores = array($widgetId.'g',$widgetId.'h',$widgetId.'i');
								$i = 0;


					        	if ($tipo_widget == 'widgetSubhomeIntroduccion'){

				?>						 
									<div class="impact container">
	    								<section class="impact-section">
						                    <h1><?php echo $title; ?></h1>
						                    <p class="initial-description"><?php echo $texto; ?></p>
						                </section>
						                <section class="micro-section mb-xxl">
						                    <div class="row">					                 
				<?php

									while ($query->have_posts()) : $query->the_post();

											$identificador = $identificadores[$i];

											$post_id = get_the_id();
											$visualizacion = (get_post_meta($post_id, 'visualizacion', true)) ? get_post_meta($post_id, 'visualizacion', true) : "circulo";
											$color_dato = get_post_meta($post_id, 'color_dato', true);
											$etiqueta = mb_strtoupper(get_post_meta($post_id, 'etiqueta', true), 'UTF-8');
											$completado = get_post_meta($post_id, 'completado', true);

											pintaWidgetDatos($etiqueta, $color_dato, $completado, $identificador);

											$i++;
										endwhile;

										wp_reset_postdata();
				?>

									        </div>
										</section>
									</div>
				<?php

		    					}
		    					else if($tipo_widget == 'widgetSubhomeSecundario'){

		    	?>						 
									<div class="impact container">
										<section class="micro-section mb-xxl">
						                    <h1><?php echo $title; ?></h1>
						                    <p><?php echo $texto; ?></p>
						                    <div class="row">
	                 
				<?php
									while ($query->have_posts()) : $query->the_post();

											$identificador = $identificadores[$i];

											$post_id = get_the_id();
											$visualizacion = (get_post_meta($post_id, 'visualizacion', true)) ? get_post_meta($post_id, 'visualizacion', true) : "circulo";
											$color_dato = get_post_meta($post_id, 'color_dato', true);
											$etiqueta = mb_strtoupper(get_post_meta($post_id, 'etiqueta', true), 'UTF-8');
											$completado = get_post_meta($post_id, 'completado', true);

											pintaWidgetDatos($etiqueta, $color_dato, $completado, $identificador);

											$i++;
										endwhile;

										wp_reset_postdata();


				?>

									        </div>
										</section>
									</div>
				<?php

		    					}
							}
							else {
				
								_e("No hay impactos disponibles.", "os_impactos_widget");
							}

	    				}break;

	    			}
	    		}
	    }





	    public function form($instance) {
	    	
	    	$title = ! empty($instance['title']) ? $instance['title'] : '';
	    	$texto = ! empty($instance['texto']) ? $instance['texto'] : '';
	    	$tipo_widget = !empty($instance['tipo_widget']) ? $instance['tipo_widget'] : '';
	    	$tipo_impactos =  ! empty($instance['tipo_impactos']) ? $instance['tipo_impactos'] : '';
	    	$subhome_impactos = !empty($instance['subhome_impactos']) ? $instance['subhome_impactos'] : 0;
	    	$impacto_1_circulo = ! empty($instance['impacto_1_circulo']) ? $instance['impacto_1_circulo'] : '';
	    	$impacto_2_circulo = ! empty($instance['impacto_2_circulo']) ? $instance['impacto_2_circulo'] : '';
	    	$impacto_3_circulo = ! empty($instance['impacto_3_circulo']) ? $instance['impacto_3_circulo'] : '';	
	    	$impacto_1_barra = ! empty($instance['impacto_1_barra']) ? $instance['impacto_1_barra'] : '';
	    	$impacto_2_barra = ! empty($instance['impacto_2_barra']) ? $instance['impacto_2_barra'] : '';
	    	$impacto_1_dato = ! empty($instance['impacto_1_dato']) ? $instance['impacto_1_dato'] : '';
	    	$impacto_2_dato = ! empty($instance['impacto_2_dato']) ? $instance['impacto_2_dato'] : '';
	    	$impacto_3_dato = ! empty($instance['impacto_3_dato']) ? $instance['impacto_3_dato'] : '';
	    	

		    	$argsCirculos = array(
					'posts_per_page'   => -1,
					'offset'           => 0,
					'category'         => '',
					'orderby'          => 'post_date',
					'order'            => 'DESC',
					'include'          => '',
					'exclude'          => '',
					'meta_key'         => 'visualizacion',
					'meta_value'       => 'circulo',
					'post_type'        => 'impacto',
					'post_mime_type'   => '',
					'post_parent'      => '',
					'post_status'      => 'publish',
					'suppress_filters' => true,
				);
				$impactosCirculos = get_posts($argsCirculos);

		    	$argsBarras = array(
					'posts_per_page'   => -1,
					'offset'           => 0,
					'category'         => '',
					'orderby'          => 'post_date',
					'order'            => 'DESC',
					'include'          => '',
					'exclude'          => '',
					'meta_key'         => 'visualizacion',
					'meta_value'       => 'barra',
					'post_type'        => 'impacto',
					'post_mime_type'   => '',
					'post_parent'      => '',
					'post_status'      => 'publish',
					'suppress_filters' => true,
				);
				$impactosBarras = get_posts($argsBarras);
    	
	    		$argsDatos = array(
					'posts_per_page'   => -1,
					'offset'           => 0,
					'category'         => '',
					'orderby'          => 'post_date',
					'order'            => 'DESC',
					'include'          => '',
					'exclude'          => '',
					'meta_key'         => 'visualizacion',
					'meta_value'       => 'dato',
					'post_type'        => 'impacto',
					'post_mime_type'   => '',
					'post_parent'      => '',
					'post_status'      => 'publish',
					'suppress_filters' => true,
				); 
				$impactosDatos = get_posts($argsDatos);

	    	
		    	$argsPage = array(
				    'depth'                 => 0,
				    'child_of'              => 0,
				    'selected'              => $subhome_impactos,
				    'echo'                  => 1,
				    'name'                  => $this->get_field_name('subhome_impactos'),
				    'id'                    => $this->get_field_id('subhome_impactos'), // string
				    'class'                 => 'widefat', // string
				    'show_option_none'      => null, // string
				    'show_option_no_change' => null, // string
				    'option_none_value'     => null, // string
				);

	    	?>

	    	<!-- Titulo widget -->
	    	<p>
	    		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Título:', 'os_impactos_widget'); ?></label>
				<input required="required" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="url" value="<?php echo esc_attr($title); ?>">
			</p>

			<!-- Texto widget -->
	    	<p>
	    		<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto:', 'os_impactos_widget'); ?></label>
				<textarea required="required" class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>"><?php echo $texto; ?></textarea>
			</p>

			<!-- Lugar de colocacion del y tipo widget -->
			<p>
				<label for="<?php echo $this->get_field_id('tipo_widget'); ?>"><?php _e('Tipo de widget:', 'os_impactos_widget'); ?></label></br>
				<input type="radio" class="tipo_widget" id="<?php echo $this->get_field_id('tipo_widget') . '-home'; ?>"  <?php checked($tipo_widget,"widgetHome"); ?> name="<?php echo $this->get_field_name('tipo_widget'); ?>" value="widgetHome"><label for="<?php echo $this->get_field_id('tipo_widget') . '-home'; ?>"><?php _e('Widget Home', 'os_impactos_widget'); ?></label></br>

				<input type="radio" class="tipo_widget" id="<?php echo $this->get_field_id('tipo_widget') . '-subhomeIntro'; ?>" <?php checked($tipo_widget,"widgetSubhomeIntroduccion"); ?> name="<?php echo $this->get_field_name('tipo_widget'); ?>" value="widgetSubhomeIntroduccion"><label for="<?php echo $this->get_field_id('tipo_widget') . '-subhomeIntro'; ?>"><?php _e('Widget Subhome impactos introducción', 'os_impactos_widget'); ?></label></br>

				<input type="radio" class="tipo_widget" id="<?php echo $this->get_field_id('tipo_widget') . '-subhomeSecundario'; ?>" <?php checked($tipo_widget,"widgetSubhomeSecundario"); ?> name="<?php echo $this->get_field_name('tipo_widget'); ?>" value="widgetSubhomeSecundario"><label for="<?php echo $this->get_field_id('tipo_widget') . '-subhomeSecundario'; ?>"><?php _e('Widget Subhome impactos secundario', 'os_impactos_widget'); ?></label></br>	
	    	</p>

	    	<!-- Tipo de impacto -->
	    	<p>
				<label for="<?php echo $this->get_field_id('tipo_impactos'); ?>"><?php _e('Tipo de impactos:', 'os_impactos_widget'); ?></label></br>
				<input type="radio" class="tipo_impactos circulo" id="<?php echo $this->get_field_id('tipo_impactos') . '-circulo'; ?>"  <?php checked($tipo_impactos,"circulo"); ?> name="<?php echo $this->get_field_name('tipo_impactos'); ?>" value="circulo"><label for="<?php echo $this->get_field_id('tipo_impactos') . '-circulo'; ?>"><?php _e('Circulos', 'os_impactos_widget'); ?></label></br>
				<input type="radio" class="tipo_impactos barra" id="<?php echo $this->get_field_id('tipo_impactos') . '-barra'; ?>" <?php checked($tipo_impactos,"barra"); ?> name="<?php echo $this->get_field_name('tipo_impactos'); ?>" value="barra"><label for="<?php echo $this->get_field_id('tipo_impactos') . '-barra'; ?>"><?php _e('Barras', 'os_impactos_widget'); ?></label></br>	
				<input type="radio" class="tipo_impactos dato" id="<?php echo $this->get_field_id('tipo_impactos') . '-dato'; ?>" <?php checked($tipo_impactos,"dato"); ?> name="<?php echo $this->get_field_name('tipo_impactos'); ?>" value="dato"><label for="<?php echo $this->get_field_id('tipo_impactos') . '-dato'; ?>"><?php _e('Dato', 'os_impactos_widget'); ?></label></br>	
	    	</p>

			<!-- URL widget -->
	    	<p id="url_home" <?php if ($tipo_widget != "widgetHome") echo 'style="display: none;"'; ?>>
				<label for="<?php echo $this->get_field_id('subhome_impactos'); ?>"><?php _e('Subhome de impactos:', 'os_impactos_widget'); ?></label>
				<?php wp_dropdown_pages($argsPage); ?>
			</p>


			<!-- Circulos -->
			<div id="impactosCirculo" <?php if ($tipo_impactos != "circulo") echo 'style="display: none;"'; ?>>
				<p>
					<label for="<?php echo $this->get_field_id('impacto_1_circulo'); ?>"><?php _e('1º Impacto circulo:', 'os_impactos_widget'); ?></label>
					<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_1_circulo'); ?>" name="<?php echo $this->get_field_name('impacto_1_circulo'); ?>">
					  <?php if (!(empty($impactosCirculos))) : ?>
					  <?php foreach ($impactosCirculos as $impactoCirculo) : ?>
					  <?php 
					  	$impacto_title = !(empty($impactoCirculo->post_title)) ? $impactoCirculo->post_title : __("Sin título", "os_impactos_widget");
					  ?>
					  <?php $selected = ($impactoCirculo->ID == $impacto_1_circulo) ? 'selected="selected"' : ':'; ?>
					  <option value="<?php echo $impactoCirculo->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
					  <?php endforeach; ?>
					  <?php else: ?>
					  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_widget'); ?></option>
					  <?php endif; ?>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('impacto_2_circulo'); ?>"><?php _e('2º Impacto circulo:', 'os_impactos_widget'); ?></label>
					<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_2_circulo'); ?>" name="<?php echo $this->get_field_name('impacto_2_circulo'); ?>">
					  <?php if (!(empty($impactosCirculos))) : ?>
					  <?php foreach ($impactosCirculos as $impactoCirculo) : ?>
					  <?php 
					  	$impacto_title = !(empty($impactoCirculo->post_title)) ? $impactoCirculo->post_title : __("Sin título", "os_impactos_widget");
					  ?>
					  <?php $selected = ($impactoCirculo->ID == $impacto_2_circulo) ? 'selected="selected"' : ':'; ?>
					  <option value="<?php echo $impactoCirculo->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
					  <?php endforeach; ?>
					  <?php else: ?>
					  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_widget'); ?></option>
					  <?php endif; ?>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('impacto_3_circulo'); ?>"><?php _e('3º Impacto circulo:', 'os_impactos_widget'); ?></label>
					<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_3_circulo'); ?>" name="<?php echo $this->get_field_name('impacto_3_circulo'); ?>">
					  <?php if (!(empty($impactosCirculos))) : ?>
					  <?php foreach ($impactosCirculos as $impactoCirculo) : ?>
					  <?php 
					  	$impacto_title = !(empty($impactoCirculo->post_title)) ? $impactoCirculo->post_title : __("Sin título", "os_impactos_widget");
					  ?>
					  <?php $selected = ($impactoCirculo->ID == $impacto_3_circulo) ? 'selected="selected"' : ':'; ?>
					  <option value="<?php echo $impactoCirculo->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
					  <?php endforeach; ?>
					  <?php else: ?>
					  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_widget'); ?></option>
					  <?php endif; ?>
					</select>
				</p>
			</div>


			<!-- Barra -->
			<div id="impactosBarra" <?php if ($tipo_impactos != "barra") echo 'style="display: none;"'; ?>>
				<p>
					<label for="<?php echo $this->get_field_id('impacto_1_barra'); ?>"><?php _e('1º Impacto barra:', 'os_impactos_widget'); ?></label>
					<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_1_barra'); ?>" name="<?php echo $this->get_field_name('impacto_1_barra'); ?>">
					  <?php if (!(empty($impactosBarras))) : ?>
					  <?php foreach ($impactosBarras as $impactoBarra) : ?>
					  <?php 
					  	$impacto_title = !(empty($impactoBarra->post_title)) ? $impactoBarra->post_title : __("Sin título", "os_impactos_widget");
					  ?>
					  <?php $selected = ($impactoBarra->ID == $impacto_1_barra) ? 'selected="selected"' : ':'; ?>
					  <option value="<?php echo $impactoBarra->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
					  <?php endforeach; ?>
					  <?php else: ?>
					  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_widget'); ?></option>
					  <?php endif; ?>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('impacto_2_barra'); ?>"><?php _e('2º Impacto barra:', 'os_impactos_widget'); ?></label>
					<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_2_barra'); ?>" name="<?php echo $this->get_field_name('impacto_2_barra'); ?>">
					  <?php if (!(empty($impactosBarras))) : ?>
					  <?php foreach ($impactosBarras as $impactoBarra) : ?>
					  <?php 
					  	$impacto_title = !(empty($impactoBarra->post_title)) ? $impactoBarra->post_title : __("Sin título", "os_impactos_widget");
					  ?>
					  <?php $selected = ($impactoBarra->ID == $impacto_2_barra) ? 'selected="selected"' : ':'; ?>
					  <option value="<?php echo $impactoBarra->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
					  <?php endforeach; ?>
					  <?php else: ?>
					  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_widget'); ?></option>
					  <?php endif; ?>
					</select>
				</p>
			</div>


			<!-- Dato -->
			<div id="impactosDato" <?php if ($tipo_impactos != "dato") echo 'style="display: none;"'; ?>>
				<p>
					<label for="<?php echo $this->get_field_id('impacto_1_dato'); ?>"><?php _e('1º Impacto dato:', 'os_impactos_widget'); ?></label>
					<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_1_dato'); ?>" name="<?php echo $this->get_field_name('impacto_1_dato'); ?>">
					  <?php if (!(empty($impactosDatos))) : ?>
					  <?php foreach ($impactosDatos as $impactoDato) : ?>
					  <?php 
					  	$impacto_title = !(empty($impactoDato->post_title)) ? $impactoDato->post_title : __("Sin título", "os_impactos_widget");
					  ?>
					  <?php $selected = ($impactoDato->ID == $impacto_1_dato) ? 'selected="selected"' : ':'; ?>
					  <option value="<?php echo $impactoDato->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
					  <?php endforeach; ?>
					  <?php else: ?>
					  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_widget'); ?></option>
					  <?php endif; ?>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('impacto_2_dato'); ?>"><?php _e('2º Impacto dato:', 'os_impactos_widget'); ?></label>
					<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_2_dato'); ?>" name="<?php echo $this->get_field_name('impacto_2_dato'); ?>">
					  <?php if (!(empty($impactosDatos))) : ?>
					  <?php foreach ($impactosDatos as $impactoDato) : ?>
					  <?php 
					  	$impacto_title = !(empty($impactoDato->post_title)) ? $impactoDato->post_title : __("Sin título", "os_impactos_widget");
					  ?>
					  <?php $selected = ($impactoDato->ID == $impacto_2_dato) ? 'selected="selected"' : ':'; ?>
					  <option value="<?php echo $impactoDato->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
					  <?php endforeach; ?>
					  <?php else: ?>
					  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_widget'); ?></option>
					  <?php endif; ?>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('impacto_3_dato'); ?>"><?php _e('3º Impacto dato:', 'os_impactos_widget'); ?></label>
					<select required="required" class="widefat" id="<?php echo $this->get_field_id('impacto_3_dato'); ?>" name="<?php echo $this->get_field_name('impacto_3_dato'); ?>">
					  <?php if (!(empty($impactosDatos))) : ?>
					  <?php foreach ($impactosDatos as $impactoDato) : ?>
					  <?php 
					  	$impacto_title = !(empty($impactoDato->post_title)) ? $impactoDato->post_title : __("Sin título", "os_impactos_widget");
					  ?>
					  <?php $selected = ($impactoDato->ID == $impacto_3_dato) ? 'selected="selected"' : ':'; ?>
					  <option value="<?php echo $impactoDato->ID; ?>" <?php echo $selected; ?>><?php echo $impacto_title; ?></option>
					  <?php endforeach; ?>
					  <?php else: ?>
					  <option value=""><?php _e('No hay impactos disponibles', 'os_impactos_widget'); ?></option>
					  <?php endif; ?>
					</select>
				</p>
			</div>

	    	<?php
	    }


	    function update($new_instance, $old_instance) {

	    	$instance = array();

	    	$instance['title'] = (!empty( $new_instance['title'])) ? strip_tags($new_instance['title']) : '';
	    	$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : '';
	    	$instance['tipo_widget'] = (!empty( $new_instance['tipo_widget'])) ? strip_tags($new_instance['tipo_widget']) : '';			
	    	$instance['tipo_impactos'] = (!empty( $new_instance['tipo_impactos'])) ? strip_tags($new_instance['tipo_impactos']) : '';
	    	$instance['subhome_impactos'] = (!empty( $new_instance['subhome_impactos'])) ? strip_tags($new_instance['subhome_impactos']) : 0;
	    	$instance['impacto_1_circulo'] = (!empty( $new_instance['impacto_1_circulo'])) ? strip_tags($new_instance['impacto_1_circulo']) : '';
	    	$instance['impacto_2_circulo'] = (!empty( $new_instance['impacto_2_circulo'])) ? strip_tags($new_instance['impacto_2_circulo']) : '';
	    	$instance['impacto_3_circulo'] = (!empty( $new_instance['impacto_3_circulo'])) ? strip_tags($new_instance['impacto_3_circulo']) : '';    	
	    	$instance['impacto_1_barra'] = (!empty( $new_instance['impacto_1_barra'])) ? strip_tags($new_instance['impacto_1_barra']) : '';
	    	$instance['impacto_2_barra'] = (!empty( $new_instance['impacto_2_barra'])) ? strip_tags($new_instance['impacto_2_barra']) : '';	    	
	    	$instance['impacto_1_dato'] = (!empty( $new_instance['impacto_1_dato'])) ? strip_tags($new_instance['impacto_1_dato']) : '';
	    	$instance['impacto_2_dato'] = (!empty( $new_instance['impacto_2_dato'])) ? strip_tags($new_instance['impacto_2_dato']) : '';
	    	$instance['impacto_3_dato'] = (!empty( $new_instance['impacto_3_dato'])) ? strip_tags($new_instance['impacto_3_dato']) : '';
	    	
			return $instance;
	    }


	    function register_admin_scripts($hook) {
            wp_enqueue_script('os_impactos_widget-js', plugins_url( 'js/os_impacto_widget.js' , __FILE__ ), array('jquery'));
        }

	}

	function os_impactos_widget() {
	    register_widget('os_impactos_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_impactos_widget');


endif;


function pintaWidgetHomeCirculos($etiqueta, $color, $objetivo, $completado, $identificador){

	$porcentaje = $completado / $objetivo;

	$values = thousandsCurrencyFormat($objetivo);

	?>

	<div class="col-xs-12 col-sm-4 mb-lg mt-xs text-center">
        <!-- percicle element -->
        <div class="circle-container ">
            <div id="<?php echo $identificador; ?>" class="circle-progress"></div>
            <div class="circle-footer">
                <span><?php _e("Objetivo", "os_impacto_type"); ?> <?php echo $values[0]; echo " "; echo $values[1]; ?></span>
            </div>
        </div>
        <!-- EO percicle element -->
    </div>


	<?php
	
		echo "<script>jQuery(document).ready(function() {
				setProgressBarCircle('#".$identificador."', getCircleConfig(".$values[0].", '".$color."', '#F4F4F4', '".$values[1]."', '', '".$etiqueta."'), ".$porcentaje.") });
			  </script>";
}



function pintaWidgetCirculos($etiqueta, $color, $objetivo, $completado, $identificador){

	$porcentaje = $completado / $objetivo;

	$values = thousandsCurrencyFormat($objetivo);

	?>

	<div class="col-xs-12 col-sm-4 mb-lg mt-xs text-center">
        <!-- percicle element -->
        <div class="circle-container ">
            <div id="<?php echo $identificador; ?>" class="circle-progress"></div>
            <div class="circle-footer">
                <span><?php _e("Objetivo", "os_impacto_type"); ?> <?php echo $values[0]; echo " "; echo $values[1]; ?></span>
            </div>
        </div>
        <!-- EO percicle element -->
    </div>


	<?php
	
		echo "<script>jQuery(document).ready(function() {
				setProgressBarCircle('#".$identificador."', getCircleConfig(".$values[0].", '".$color."', '#F4F4F4', '".$values[1]."', '', '".$etiqueta."'), ".$porcentaje.") });
			  </script>";
}


function pintaWidgetBarras($etiqueta, $objetivo, $completado, $identificador){


		$porcentaje = $completado / $objetivo;

		$valuesObj = thousandsCurrencyFormat($objetivo);
		$valuesCom = thousandsCurrencyFormat($completado);

	?>

	 <div class="col-xs-12 col-sm-6 mt-md">
        <div class="progressLineBar">
            <div id="<?php echo $identificador; ?>"></div>
            <div class="line-objetive">
                <span><?php echo $etiqueta; ?> <?php echo $valuesObj[0]; echo " "; echo $valuesObj[1]; ?></span>
            </div>
        </div>
    </div>


<?php

	 echo "<script>jQuery(document).ready(function() {
			setProgressBarLine('#".$identificador."', getConfig(".$objetivo.", '".$valuesCom[1]."'), ".$porcentaje.") });
		  </script>";
}

function pintaWidgetDatos($etiqueta, $color_dato, $completado, $identificador){


		$valuesCom = thousandsCurrencyFormat($completado);
		$color = 'red';

		switch ($color_dato) {

			case '#f35e61': $color =  'red'; break;
			
			case '#d8be75': $color =  'yellow'; break;
			
			case '#004481':$color =  'blue'; break;
		}

	?>

	<div class="col-xs-12 col-sm-4 mt-xs text-center">
        <!-- percicle element -->
        <div class="circle-container  circle-simple ">
            <div id="<?php echo $identificador; ?>" class="circle-progress"></div>
        </div>
        <!-- EO percicle element -->
    </div>

    <?php
	
		echo "<script>jQuery(document).ready(function() {
				setProgressBarCircle('#".$identificador."', getCircleConfig(".$completado.", 'transparent', 'transparent', '".$valuesCom[1]."', '".$color."', '".$etiqueta."'), 1) });
			  </script>";

}

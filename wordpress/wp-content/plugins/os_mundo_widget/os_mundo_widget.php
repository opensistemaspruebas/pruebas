<?php

/*
	Plugin Name: OS Mundo Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Muestra la página del mundo.
	Version: 1.0
	Author: Roberto Moreno
	Author URI: http://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_mundo_widget
*/


if (!class_exists('OSMundoWidget')) :

	class OSMundoWidget extends WP_Widget {

	    function __construct() {
	        parent::__construct(
	        	'OSMundoWidget',
	        	__('OS Mundo Widget', 'os_mundo_widget'),
	        	array(
	            	'description' => __('Muestra la página del mundo', 'os_mundo_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {


			$titulo = !empty($instance['titulo']) ? $instance['titulo'] : '';   	
	    	$texto = !empty($instance['texto']) ? $instance['texto'] : '';	
			
			?>				
				            
				<section class="back-map">
				    <div class="container">
				        <h1><?php echo $titulo ?></h1>
				        <p class="map-explanation"><?php echo $texto ?></p>
				        <div class="container_map hidden-xs">
				            <div id="map_canvas" class="content_map"></div>
				            <div class="map_message"></div>
				        </div>
				    </div>
				</section>

				<div class="container">
				    <div class="select-map">
				        <h2 class="hidden-xs"><?php _e("Programa de educación financiera", "os_mundo_widget"); ?></h2>
				        <div class="controls">
				            <select id="select-country" class="selectpicker-form countries"></select>
				            <a target="_blank" href="" class="link-web"><span id="descrPaisId"></span><span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>
				        </div>
				    </div>
				</div>
				<div class="info-country">


				<?php

				  $estado == '';

				    $args = array(
				        'posts_per_page' => -1,

				        'taxonomy' => 'ambito_geografico',
				        'hide_empty' => 0
				    );

				  $dataMap = array();
			
				  foreach (get_terms('ambito_geografico', $args ) as $tag) :

				    $arrayTaxAG = get_term_meta($tag->term_id);
				    $isoCodeAux = $arrayTaxAG['isoCode'][0];
				    $isoCodeLower = strtolower($isoCodeAux);
				    $isoCodeUpper = strtoupper($isoCodeAux);

				 	$nombrePais = $tag->name;
				    $tituloModal = $arrayTaxAG['tituloModal'][0];
				    $descripcionModal = $arrayTaxAG['descripcionModal'][0];
				    $descripURLmasInfo = $arrayTaxAG['descripURLmasInfo'][0];
				    $URLmasInfo = $arrayTaxAG['URLmasInfo'][0];
				    $descripURLaprenderMas = $arrayTaxAG['descripURLaprenderMas'][0];
				    $URLaprenderMas = $arrayTaxAG['URLaprenderMas'][0];
				    $tituloMicrofinanzas = $arrayTaxAG['tituloMicrofinanzas'][0];
				    $descripcionMicrofinanzas = $arrayTaxAG['descripcionMicrofinanzas'][0];
				    $descripURLmicrofinanzasUno = $arrayTaxAG['descripURLmicrofinanzasUno'][0];
				    $URLMicrofinanzasUno = $arrayTaxAG['URLMicrofinanzasUno'][0];
				    $descripURLmicrofinanzasDos = $arrayTaxAG['descripURLmicrofinanzasDos'][0];
				    $URLMicrofinanzasDos = $arrayTaxAG['URLMicrofinanzasDos'][0];
				    $descripURLpais = $arrayTaxAG['descripURLpais'][0];
				    $URLpais = $arrayTaxAG['URLpais'][0];

				    $elemento = array();
				  
	                $elemento['id'] = $isoCodeUpper;
	                $elemento['country'] = $nombrePais;
	                $elemento['title'] = $tituloModal;
	                $elemento['text'] = $descripcionModal;
	                $elemento['button'] = $descripURLmasInfo;
	                $elemento['link'] = $URLmasInfo;
	               	$elemento['descPais'] = $descripURLpais;
	                $elemento['urlPais'] = $URLpais;

	                $dataMap[] = $elemento;

         		?>

				    <div class="workshops <?php echo $isoCodeLower; ?>">

				    <?php $posts=query_posts('post_status=publish&post_type=taller&ambito_geografico='.$tag->slug);

				    if(empty($posts)){ ?>
				      <div class="container">
				        <div class="not-workshops">
				          <span class="icon bbva-icon-info"></span>
				          <div>
				            <h3><?php _e("En estos momentos no tenemos talleres disponibles en ", "os_mundo_widget"); ?><span class="current-country"></span></h3>
				            <p><?php _e("Puedes consultar el portal de Educación Financiera para conocer mejor la oferta educativa del país.", "os_mundo_widget"); ?></p>
				            <a target="_blank" href="<?php echo $URLaprenderMas; ?>"><?php echo $descripURLaprenderMas; ?></a>
				          </div>
				        </div>
				      </div>
				        <?php if($tag->slug != $estado) {
				          $estado = $tag->slug;
				        }
				        ?>  
				    <?php } else {
				     ?>
				      <?php $i = 0; ?>
				      <?php foreach ($posts as $post) :
				       
				        $numTalleres = count($posts);

				        $title = $post->post_title;
				        $descp = get_post_meta($post->ID, 'descp', true);
				        $nombre_link = get_post_meta($post->ID, 'nombre_link', true);
				        $link_taller = get_post_meta($post->ID, 'link_taller', true);
				        $externo = get_post_meta($post->ID, 'externo', true);
				?>

				        <?php if($tag->slug != $estado) {
				                $estado = $tag->slug;
				        ?>        

				            <article id="otros_talleres" name="otros_talleres" class="container data-grid">

				              <header>
				                <h1><?php _e("Talleres del país", "os_mundo_widget"); ?></h1>
				              </header>

				              <div class="content">
				                <div class="grid-wrapper">

				        <?php } ?>
				      
				                    <section id="taller_<?php echo $i; ?>" name="taller_<?php echo $i; ?>" class="data-block" <?php if ($i > 5) echo 'style="display:none;"'; ?>>
				                      <h2><?php echo $title;?></h2>
				                      <p class="description"><?php echo $descp;?></p>
				                      <p class="link"><a <?php if ($externo == "on") echo 'target="_blank"';?> href="<?php echo $link_taller;?>"><?php echo $nombre_link;?><span class="icon bbva-icon-link_external font-xs mr-xs"></span></a></p>
				                    </section>
				            
				             <?php $i++; ?>       
				       <?php endforeach; ?> 
				                 </div>
				                </div>


				              
				       <?php  if($numTalleres > 6){ ?>

				                <footer id="esconder" class="grid-footer">
				                  <div class="row">
				                    <div class="col-md-12 text-center">
				                      <a href="javascript:void(0)" id="readmore_talleres" name="readmore_talleres" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e("Más talleres", "os_mundo_widget"); ?></a>
				                    </div>
				                  </div>
				                </footer>

				       <?php  } ?>        

				              </article>
				 
				  <?php } ?>

				<!-- Aqui va el widget Logos-->
				<?php 
				          the_widget(
				                'os_logos_widget', 
				                array(
				                    'titulo' => __('Nuestros aliados en'),
				                    'texto' => '',
				                    'numero_posts_mostrar' => '6',
				                    'numero_posts_totales' => '6',
				                    'tipo_post' => 'partners',
				                    'ambito_geografico' => $tag->slug,
				                    'cod_pais' => $isoCodeAux
				                )
				            );
				?>
				<!-- Hasta aqui va el widget Logos-->

				                   <!-- EO council-members-map -->
				    <?php if(!empty($tituloMicrofinanzas) || !empty($descripcionMicrofinanzas) || !empty($descripURLmicrofinanzasUno) || !empty($descripURLmicrofinanzasDos)) : ?>               
	                    <div class="container microfinance">
	                        <h2><?php echo $tituloMicrofinanzas;?></h2>
	                        <p><?php echo $descripcionMicrofinanzas;?></p>
	                        <a target="_blank" href="<?php echo $URLMicrofinanzasUno;?>"><?php echo $descripURLmicrofinanzasUno;?><span class="icon bbva-icon-link_external font-xs mr-xs"></span></a> <a target="_blank" href="<?php echo $URLMicrofinanzasDos;?>"><?php echo $descripURLmicrofinanzasDos;?><span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>
	                    </div>

                    <?php endif; ?>

				</div>
				<?php endforeach; ?>

				<?php echo "<script>var dataMap = " . json_encode($dataMap) . ";</script>"; ?>

				</div>

	    	<?php

	    }


	    public function form($instance) {
	    	
	    	$titulo = !empty($instance['titulo']) ? $instance['titulo'] : '';   	
	    	$texto = !empty($instance['texto']) ? $instance['texto'] : '';
	    	
	    	?>

	    	<p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título:', 'os_mundo_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto:', 'os_mundo_widget'); ?></label>
				<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>" type="text"><?php echo esc_attr($texto); ?></textarea>
			</p>
			<?php
	    }


	    function update($new_instance, $old_instance) {

			$instance = $old_instance;

			$instance['titulo'] = (!empty( $new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : '';
			$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : '';

			return $instance;
	    }

	}

	function os_mundo_widget() {
	    register_widget('OSMundoWidget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_mundo_widget');


endif;
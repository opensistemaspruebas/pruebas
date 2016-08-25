<?php
/**
 * Search Results Template File
 */
?>

<?php get_header(); ?>

<main id="mainContent" class="template_pagFinal_col-12" data-role="content">
    <div class="wrapperFix">
        
         <div id="bloque_introPagina">
         	<div class="colCompleta row">
            	 
            	<aside class="aside_migasPan">
            	 	<div class="wrapperContent">
                    	<p class="pagina_migas"><?php //the_breadcrumb(); ?></p>
                	</div>
                </aside>
                 
				<div id="moduloContenido_introPagina" class="introAzul">
					<div class="wrapperContent">
                        <h1 class="pagina_titulo"><?php _e("Resultado de búsqueda"); ?></h1>
                        <p class="pagina_texto_busqueda"><?php _e("Tu búsqueda"); ?>: <strong><?php echo get_search_query(); ?></strong></p>
                        <div class="pagina_icono"><i class="icon-lupa"></i></div>
						<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						    <div>
						        <label class="screen-reader-text" for="s"><?php _e('Realiza una nueva búsqueda'); ?></label>
						        <input type="text" placeholder="<?php _e('Escriba aquí su búsqueda'); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />						        						        
						        <span class="icon-lupa"></span>
						    </div>
						</form>                        
                    </div>                   
                </div>
        	
        	</div>        
        </div>
                
        <div id="bloque_contenidoPrincipal" class="busqueda">
            <div class="colCompleta row">            	            
                <?php if (!empty(get_search_query())) : ?>                
                <?php if ( have_posts() ) :  // results found?>                	
                	<?php $num = $wp_query->found_posts; ?>
                	<p class="numero_resultados">
                		<?php 
                			if ($num > 1) {
                				echo __("Se han encontrado") . ' ' . $num . ' ' . __("resultados") . ' (';
                			} else {
                				echo __("Se ha encontrado") . ' ' . $num . ' ' . __("resultado") . ' (';
                			}
                			timer_stop(1);
                			echo ' '. __("segundos") . ')';
                		?>
                	</p>           
                	<?php
                	global $wpdb;
					$widget_query = "SELECT option_value FROM prov_options WHERE option_name LIKE 'widget_content'";
					$contents_result = $wpdb->get_results($widget_query)[0];
					$contents = unserialize($contents_result->option_value);

					$widget_query = "SELECT option_value FROM prov_options WHERE option_name LIKE 'widget_tools'";
					$tools_result = $wpdb->get_results($widget_query)[0];
					$tools = unserialize($tools_result->option_value);	


					$widget_query = "SELECT option_value FROM prov_options WHERE option_name LIKE 'widget_country_cards'";
					$countries_result = $wpdb->get_results($widget_query)[0];
					$countries = unserialize($countries_result->option_value);	

					$widget_query = "SELECT option_value FROM prov_options WHERE option_name LIKE 'widget_faqs'";
					$faqs_result = $wpdb->get_results($widget_query)[0];
					$faqs = unserialize($faqs_result->option_value);							
									
                	?>     	
					<?php while ( have_posts() ) : the_post(); ?>
						<article class="resultado_busqueda">
								<?php 
								$post_type = get_post_type();								
								$obj = get_post_type_object($post_type);								
								if($obj->label == 'Contents'){
									$enlace = get_the_content_page_link(get_the_ID(), $contents);
								}elseif($obj->label == 'Tools'){
									$enlace = get_the_others_page_link(get_the_ID(), $tools);
								}elseif($obj->label == 'Country Cards'){
									$enlace = get_the_others_page_link(get_the_ID(), $countries);
								}elseif($obj->label == 'FAQs'){
									$enlace = get_the_others_page_link(get_the_ID(), $faqs);				
								}elseif($post_type == 'attachment'){
									$enlace = get_the_guid();
								}else{
									$enlace = get_the_permalink();
								}
								?>								
							<h2 class="titulo_resultado"><a href="<?php echo $enlace; ?>"><?php the_title();  ?></a></h2>
								<?php 
								$post_type = get_post_type();
								$obj = get_post_type_object($post_type);
								?>										
							<p class="link_resultado"><?php echo $enlace; ?></p>
							<p class="tipo_resultado">
							<?php								
								if($post_type == "attachment"){
									_e("Documento");
								} else {
									echo $obj->labels->singular_name;
								}							
							?></p>							
							<p>
							<?php 
								
								if($post_type !== 'attachment' && !empty(get_the_content()) && (get_the_content() !== '')) {
									echo strip_tags(substr(get_the_content(), 0, 340)) . ' [...]';
								}				
							?>								
							</p>
						</article>
					<?php endwhile; ?>
				<?php else :  // no results?>
					<article>
						<h1><?php _e("No se han encontrado resultados."); ?></h1>
					</article>
				<?php endif; ?>
				<?php else : ?>
					<article>
						<h1><?php _e("Debe introducir un término para la búsqueda."); ?></h1>
					</article>
				<?php endif; ?>

				<?php
					$args = array(						
						'prev_next' => true,
						'prev_text' => __('< Pág Anterior'),
						'next_text' => __('Pág Siguiente >'),
						'type' => 'plain',						
						'before_page_number' => '<span class="enlace-pagina_f">',
						'after_page_number'  => '</span>'
					);
				?>	
				<aside id="aside_paginacionBottom">
					<div class="wrapperContent">
						<p class="pagNumeracion">
							<?php 
								if ($num > 1) {
									echo paginate_links($args); 
								}
							?>					
						</p>
					</div>
				</aside>
            </div>
        </div>
        <div id="bloque_contenidoSecundario">
            <div class="colCompleta row">
                <?php get_sidebar( 'grupoSec_colCompleta' )?>
            </div>
        </div>
     </div>
</main> 

<?php get_footer(); ?>

<?php 

function get_the_content_page_link($post_id, $contents){
	foreach($contents as $one_content){
		if ($one_content['content-post'] == $post_id){
			$claves = array_keys($one_content);
			foreach($claves as $clave){
				if (preg_match("/page-/", $clave)){
					$page_post_id = substr($clave, 5);
					$post = get_post($page_post_id); 
					$slug = $post->post_name;
					if ($slug){
						return($slug);
					}					
				}
			}
		}
	}
	return "slug no encontrado";	
}

function get_the_others_page_link($post_id, $tools){
	foreach($tools as $one_tool){
		$claves = array_keys($one_tool);
		foreach($claves as $clave){
			if (preg_match("/page-/", $clave)){
				$page_post_id = substr($clave, 5);
				$post = get_post($page_post_id); 
				$slug = $post->post_name;
				if ($slug){
					return($slug);
				}					
			}
		}
	}
	return "slug no encontrado";	
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset=	"<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
</head>

<body>
<div id="content" data-role="page" class="">
    <header id="mainHeader" data-role="header">
    	<div class="wrapperFluid">
        
        	<section id="header_logo">
               <div class="wrapperContent">
                    <h1 id="header_logoBBVA"> 
                      <span id="header_logoBBVAGlobal"><a href="<?php echo get_option('home'); ?>"><img title="" src="<?php echo get_template_directory_uri(); ?>/resources/images/logosPaises/logoBlanco_BBVA.svg" /></a></span> 
                      <span id="header_nombrePortal"><?php bloginfo('name'); ?></span> 
                    </h1>
                </div>
			</section>
            
            <nav id="menu_navegacionPrincipal">
            	<div class="wrapperContent">
                    <?php
                    $args = array(
                        'menu' => $menu_header, 
                        'container' => 'div', 
                        'container_class' => '', 
                        'container_id' => '', 
                        'menu_class' => 'menu', 
                        'menu_id' => '',
                        'echo' => true, 
                        'fallback_cb' => 'wp_page_menu', 
                        'before' => '', 
                        'after' => '', 
                        'link_before' => '', 
                        'link_after' => '', 
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth' => 0, 
                        'walker' => '', 
                        'theme_location' => ''
                    );
                    ?>
					<?php wp_nav_menu($args); ?>
				</div>
            </nav>
            
            <section id="header_buscadorGeneral">
            	<div class="wrapperContent">
                    <div class="wrapperPosicionado">
                        <p id="buscadorGeneral_lupa"> <a id="toggleBuscadorGeneral" class="icon-lupa closed" href="#"><span class="textoIconoOcultar">Busca en nuestra web</span></a></p>
                    	<div class="componente_BUSCADORgeneral" id="buscadorGeneralExtensible" style="display:none;"> 
                            <form action="/resultados.html" method="get" data-ajax="false">
                                <fieldset>
                                    <label xml:lang="es" for="inpbuscar_general" lang="es"><?php _e('Buscar'); ?></label>
                                    <input style="width: 176px;" data-role="none" id="inpbuscar_general" class="text" xml:lang="es" placeholder="_Escribe aquí tu busqueda" title="Search" name="q" lang="es" type="text">
                                    <input data-role="none" id="btnbuscar_general" value="<?php _e('Buscar'); ?>" xml:lang="es" name="btnbuscar_general" lang="es" type="submit">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
          	</section>
            
            <section id="header_tools">
            	<div class="wrapperContent">
            		<div class="wrapperPosicionado">
                    	<!--<ul id="recursivos_idiomasPortal" class="idiomasPortal">
                                <li class="item_01 activo"><a href="">English</a></li>
                                <li class="item_02 inactivo"><a href="">Español</a></li>
                         </ul>-->
                         <?php //do_action('wpml_add_language_selector'); ?>
                        
                	</div>
            	</div>
          	</section>
            
    	</div>
    </header>

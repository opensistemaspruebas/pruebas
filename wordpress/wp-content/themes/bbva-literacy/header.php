<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset=	"<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title(); ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />

	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
	<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/resources/css/style_responsive.css" type="text/css" />
    <link href="<?php echo get_template_directory_uri(); ?>/resources/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/resources/css/normalize.css" type="text/css" />-->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
 	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script> 
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery.selectbox-0.2.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery.persistentpanel.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/script.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
     
     <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <script type="text/javascript" src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>

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
					<?php wp_nav_menu( array('menu' => $menu_header )); ?>
				</div>
            </nav>
            
            <section id="header_buscadorGeneral">
            	<div class="wrapperContent">
                    <div class="wrapperPosicionado">
                        <p id="buscadorGeneral_lupa"> <a id="toggleBuscadorGeneral" class="icon-lupa closed" href="#"><span class="textoIconoOcultar">Busca en nuestra web</span></a></p>
                    	<div class="componente_BUSCADORgeneral" id="buscadorGeneralExtensible" style="display:none;"> 
                            <form action="/resultados.html" method="get" data-ajax="false">
                                <fieldset>
                                    <label xml:lang="es" for="inpbuscar_general" lang="es">Buscar</label>
                                    <input style="width: 176px;" data-role="none" id="inpbuscar_general" class="text" xml:lang="es" placeholder="_Escribe aquí tu busqueda" title="Search" name="q" lang="es" type="text">
                                    <input data-role="none" id="btnbuscar_general" value="Buscar" xml:lang="es" name="btnbuscar_general" lang="es" type="submit">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
          	</section>
            
            <section id="header_tools">
            	<div class="wrapperContent">
            		<div class="wrapperPosicionado">
                    	<ul id="recursivos_idiomasPortal" class="idiomasPortal">
                                <li class="item_01 activo"><a href="">English</a></li>
                                <li class="item_02 inactivo"><a href="">Español</a></li>
                         </ul>
                        
                	</div>
            	</div>
          	</section>
            
    	</div>
    </header>
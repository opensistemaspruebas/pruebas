<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset=	"<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title(); ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />

    <!-- indicar las páginas que se quieren indexar -->
    <meta name="wp_search" content="true" />

    <?php if(ICL_LANGUAGE_CODE=="es"){
    ?>
    <meta name="Keywords" content="Ser proveedor BBVA,Proveedor BBVA,Proveedores BBVA,Cómo ser proveedor BBVA,Trabajar con BBVA,Colaborar con BBVA,Compras BBVA,Cómo vender a BBVA,Negociar con BBVA,Qué compra BBVA,Adquisiciones BBVA,Registrarme como proveedor BBVA,Aprovisionamiento BBVA,Portal proveedores BBVA,Ser proveedor Compass,Proveedor Compass,Proveedores Compass,Cómo ser proveedor Compass,Trabajar con Compass,Colaborar con Compass,Compras Compass,Cómo vender a Compass,Negociar con Compass,Qué compra Compass,Adquisiciones Compass,Registrarme como proveedor Compass,Aprovisionamiento Compass,Portal proveedores Compass,Ser proveedor Bancomer,Proveedor Bancomer,Proveedores Bancomer,Cómo ser proveedor Bancomer,Trabajar con Bancomer,Colaborar con Bancomer,Compras Bancomer,Cómo vender a Bancomer,Negociar con Bancomer,Qué compra Bancomer,Adquisiciones Bancomer,Registrarme como proveedor Bancomer,Aprovisionamiento Bancomer,Portal proveedores Bancomer,Ser proveedor BBVA Francés,Proveedor BBVA Francés,Proveedores BBVA Francés,Cómo ser proveedor BBVA Francés,Trabajar con BBVA Francés,Colaborar con BBVA Francés,Compras BBVA Francés,Cómo vender a BBVA Francés,Negociar con BBVA Francés,Qué compra BBVA Francés,Adquisiciones BBVA Francés,Registrarme como proveedor BBVA Francés,Aprovisionamiento BBVA Francés,Portal proveedores BBVA Francés,Ser proveedor BBVA Continental,Proveedor BBVA Continental,Proveedores BBVA Continental,Cómo ser proveedor BBVA Continental,Trabajar con BBVA Continental,Colaborar con BBVA Continental,Compras BBVA Continental,Cómo vender a BBVA Continental,Negociar con BBVA Continental,Qué compra BBVA Continental,Adquisiciones BBVA Continental,Registrarme como proveedor BBVA Continental,Aprovisionamiento BBVA Continental,Portal proveedores BBVA Continental,Ser proveedor BBVA Chile,Proveedor BBVA Chile,Proveedores BBVA Chile,Cómo ser proveedor BBVA Chile,Trabajar con BBVA Chile,Colaborar con BBVA Chile,Compras BBVA Chile,Cómo vender a BBVA Chile,Negociar con BBVA Chile,Qué compra BBVA Chile,Adquisiciones BBVA Chile,Registrarme como proveedor BBVA Chile,Aprovisionamiento BBVA Chile,Portal proveedores BBVA Chile,Ser proveedor BBVA Provincial,Proveedor BBVA Provincial,Proveedores BBVA Provincial,Cómo ser proveedor BBVA Provincial,Trabajar con BBVA Provincial,Colaborar con BBVA Provincial,Compras BBVA Provincial,Cómo vender a BBVA Provincial,Negociar con BBVA Provincial,Qué compra BBVA Provincial,Adquisiciones BBVA Provincial,Registrarme como proveedor BBVA Provincial,Aprovisionamiento BBVA Provincial,Portal proveedores BBVA Provincial,Ser proveedor BBVA Uruguay,Proveedor BBVA Uruguay,Proveedores BBVA Uruguay,Cómo ser proveedor BBVA Urugay,Trabajar con BBVA Uruguay,Colaborar con BBVA Uruguay,Compras BBVA Uruguay,Cómo vender a BBVA Uruguay,Negociar con BBVA Uruguay,Qué compra BBVA Uruguay,Adquisiciones BBVA Uruguay,Registrarme como proveedor BBVA Uruguay,Aprovisionamiento BBVA Uruguay,Portal proveedores BBVA Uruguay,Ser proveedor BBVA Paraguay,Proveedor BBVA Paraguay,Proveedores BBVA Paraguay,Cómo ser proveedor BBVA Paraguay,Trabajar con BBVA Paraguay,Colaborar con BBVA Paraguay,Compras BBVA Paraguay,Cómo vender a BBVA Paraguay,Negociar con BBVA Paraguay,Qué compra BBVA Paraguay,Adquisiciones BBVA Paraguay,Registrarme como proveedor BBVA Paraguay,Aprovisionamiento BBVA Paraguay,Portal proveedores BBVA Paraguay,Ser proveedor BBVA Colombia,Proveedor BBVA Colombia,Proveedores BBVA Colombia,Cómo ser proveedor BBVA Colombia,Trabajar con BBVA Colombia,Colaborar con BBVA Colombia,Compras BBVA Colombia,Cómo vender a BBVA Colombia,Negociar con BBVA Colombia,Qué compra BBVA Colombia,Adquisiciones BBVA Colombia,Registrarme como proveedor BBVA Colombia,Aprovisionamiento BBVA Colombia,Portal proveedores BBVA Colombia" />
    <?php }else{
    ?>
    <meta name="Keywords" content="BBVA supplier,Supplier BBVA,Suppliers BBVA,How to be a BBVA supplier,Work with BBVA,Collaborate with BBVA,BBVA purchasing,Trade with BBVA,Negotiate with BBVA,What does BBVA buy?,BBVA purchase,Sign in as a supplier for BBVA,BBVA purchase,BBVA Supplier website,Compass supplier,Supplier Compass,Suppliers Compass,How to be a Compass supplier,Work with Compass,Collaborate with Compass,Compass purchasing,Trade with Compass,Negotiate with Compass,What does Compass buy?,Compass purchase,Sign in as a supplier for Compass,Compass purchase,Compass Supplier website,Bancomer supplier,Supplier Bancomer,Suppliers Bancomer,How to be a Bancomer supplier,Work with Bancomer,Collaborate with Bancomer,Bancomer purchasing,Trade with Bancomer,Negotiate with Bancomer,What does Bancomer buy?,Bancomer purchase,Sign in as a supplier for Bancomer,Bancomer purchase,Bancomer Supplier website,BBVA Francés supplier,Supplier BBVA Francés,Suppliers BBVA Francés,How to be a BBVA Francés supplier,Work with BBVA Francés,Collaborate with BBVA Francés,BBVA Francés purchasing,Trade with BBVA Francés,Negotiate with BBVA Francés,What does BBVA Francés buy?,BBVA Francés purchase,Sign in as a supplier for BBVA Francés,BBVA Francés purchase,BBVA Francés Supplier website,BBVA Continental supplier,Supplier BBVA Continental,Suppliers BBVA Continental,How to be a BBVA ContinentalContinental supplier,Work with BBVA Continental,Collaborate with BBVA Continental,BBVA Continental purchasing,Trade with BBVA Continental,Negotiate with BBVA Continental,What does BBVA Continental buy?,BBVA Continental purchase,Sign in as a supplier for BBVA Continental,BBVA Continental purchase,BBVA Continental Supplier website,BBVA Chile supplier,Supplier BBVA Chile,Suppliers BBVA Chile,How to be a BBVA Chile supplier,Work with BBVA Chile,Collaborate with BBVA Chile,BBVA Chile purchasing,Trade with BBVA Chile,Negotiate with BBVA Chile,What does BBVA Chile buy?,BBVA Chile purchase,Sign in as a supplier for BBVA Chile,BBVA Chile purchase,BBVA Chile Supplier website,BBVA Provincial supplier,Supplier BBVA Provincial,Suppliers BBVA Provincial,How to be a BBVA Provincial supplier,Work with BBVA Provincial,Collaborate with BBVA Provincial,BBVA Provincial purchasing,Trade with BBVA Provincial,Negotiate with BBVA Provincial,What does BBVA Provincial buy?,BBVA Provincial purchase,Sign in as a supplier for BBVA Provincial,BBVA Provincial purchase,BBVA Provincial Supplier website,BBVA Uruguay supplier,Supplier BBVA Uruguay,Suppliers BBVA Uruguay,How to be a BBVA Uruguay supplier,Work with BBVA Uruguay,Collaborate with BBVA Uruguay,BBVA Uruguay purchasing,Trade with BBVA Uruguay,Negotiate with BBVA Uruguay,What does BBVA Uruguay buy?,BBVA Uruguay purchase,Sign in as a supplier for BBVA Uruguay,BBVA Uruguay purchase,BBVA Uruguay Supplier website,BBVA Paraguay supplier,Supplier BBVA Paraguay,Suppliers BBVA Paraguay,How to be a BBVA Paraguay supplier,Work with BBVA Paraguay,Collaborate with BBVA Paraguay,BBVA Paraguay purchasing,Trade with BBVA Paraguay,Negotiate with BBVA Paraguay,What does BBVA Paraguay buy?,BBVA Paraguay purchase,Sign in as a supplier for BBVA Paraguay,BBVA Paraguay purchase,BBVA Paraguay Supplier website,BBVA Colombia supplier,Supplier BBVA Colombia,Suppliers BBVA Colombia,How to be a BBVA Colombia supplier,Work with BBVA Colombia,Collaborate with BBVA Colombia,BBVA Colombia purchasing,Trade with BBVA Colombia,Negotiate with BBVA Colombia,What does BBVA Colombia buy?,BBVA Colombia purchase,Sign in as a supplier for BBVA Colombia,BBVA Colombia purchase,BBVA Colombia Supplier website,BBVA vendor,Vendor BBVA,Vendors BBVA,How to be a BBVA vendor,Work for BBVA,Collaborate for BBVAWhat does BBVA request?,BBVA acquisitionsCompass vendor,Vendor Compass,Vendors Compass,How to be a Compass vendor,Work for Compass,Collaborate for CompassWhat does Compass request?,Compass acquisitionBancomer vendor,Vendor Bancomer,Vendors Bancomer,How to be a Bancomer vendor,Work for Bancomer,Collaborate for BancomerWhat does Bancomer request?,Bancomer acquisitionBBVA Francés vendor,Vendor BBVA Francés,Vendors BBVA Francés,How to be a BBVA Francés vendor,Work for BBVA Francés,Collaborate for BBVA FrancésWhat does BBVA Francés request?,BBVA Francés acquisitionBBVA Continental vendor,Vendor BBVA Continental,Vendors BBVA Continental,How to be a BBVA Continental vendor,Work for BBVA Continental,Collaborate for BBVA ContinentalWhat does BBVA Continental request?,BBVA Continental acquisitionBBVA Chile vendor,Vendor BBVA Chile,Vendors BBVA Chile,How to be a BBVA Chile vendor,Work for BBVA Chile,Collaborate for BBVA ChileWhat does BBVA Chile request?,BBVA Chile acquisitionBBVA Provincial vendor,Vendor BBVA Provincial,Vendors BBVA Provincial,How to be a BBVA Provincial vendor,Work for BBVA Provincial,Collaborate for BBVA ProvincialWhat does BBVA Provincial request?,BBVA Provincial acquisitionBBVA Uruguay vendor,Vendor BBVA Uruguay,Vendors BBVA Uruguay,How to be a BBVA Uruguay vendor,Work for BBVA Uruguay,Collaborate for BBVA UruguayWhat does BBVA Uruguay request?,BBVA Uruguay acquisitionBBVA Paraguay vendor,Vendor BBVA Paraguay,Vendors BBVA Paraguay,How to be a BBVA Paraguay vendor,Work for BBVA Paraguay,Collaborate for BBVA ParaguayWhat does BBVA Paraguay request?,BBVA Paraguay acquisitionBBVA Colombia vendor,Vendor BBVA Colombia,Vendors BBVA Colombia,How to be a BBVA Colombia vendor,Work for BBVA Colombia,Collaborate for BBVA Colombia,What does BBVA Colombia request?,BBVA Colombia acquisition" />        
    <?php }
    ?>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
	<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/resources/css/style_responsive.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/resources/css/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/resources/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/resources/jquery.bxslider/jquery.bxslider.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/resources/css/mappress.css" rel="stylesheet">
    
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery.selectbox-0.2.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery.persistentpanel.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/js/script.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/jquery.bxslider/jquery.bxslider.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/resources/jPages/js/jPages.min.js"></script>
    <link href="<?php echo get_template_directory_uri(); ?>/resources/js/select2-4.0.2/dist/css/select2.min.css" rel="stylesheet" />
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/select2-4.0.2/dist/js/select2.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js?hl=<?php echo get_locale(); ?>'></script>

	<?php wp_head(); ?>

</head>
<body>

<!--Huella google analytics  -->
<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59940160-5', 'auto');
  ga('send', 'pageview');

</script>

<!-- SELECTOR DE PÁGINA PARA LA FLECHA. OBSOLETO YA QUE SE MUESTRA EN TODAS LAS WEBS. -->
<!--<?php if (preg_match("/como-ser-proveedor-pre-registro/", $_SERVER['REQUEST_URI']) || preg_match("/how-to-be-a-supplier-self-registration/", $_SERVER['REQUEST_URI']) || preg_match("/bajaproveedor/", $_SERVER['REQUEST_URI']) || preg_match("/how-to-be-a-supplier-dismiss/", $_SERVER['REQUEST_URI']) || preg_match("/modificacionproveedor/", $_SERVER['REQUEST_URI']) || preg_match("/how-to-be-a-supplier-update/", $_SERVER['REQUEST_URI']) || preg_match("/compras-responsables/", $_SERVER['REQUEST_URI']) || preg_match("/responsible-purchasing/", $_SERVER['REQUEST_URI']) || preg_match("/que-compra-bbva/",$_SERVER['REQUEST_URI']) || preg_match("/what-we-buy/", $_SERVER['REQUEST_URI']) || preg_match("/como-compra-bbva/", $_SERVER['REQUEST_URI']) || preg_match("/how-we-buy/", $_SERVER['REQUEST_URI'])) : ?>
<?php endif; ?> -->


<!-- FLECHA DE DESPLAZAMIENTO HACIA ABAJO -->
<div id="back-to-bottom">
    <a href="#" class="icon-bajar" title="Back to bottom"><span class="textoIconoOcultar">Bajar</span></a>   
</div>


<div id="content" data-role="page" class="">
    <header id="mainHeader" data-role="header">
    	<div class="wrapperFluid">
        
        	<section id="header_logo">
                <div class="coloresBBVA"><span class="bgcolor-blue_1"></span><span class="bgcolor-blue_2"></span><span class="bgcolor-blue_3"></span><span class="bgcolor-blue_4"></span><span class="bgcolor-blue_5"></span><span class="bgcolor-blue_6"></span></div>
                <div class="wrapperContent">
                    <h1 id="header_logoPais"> 
                      <span id="header_logoPaisImagen"><a href="<?php echo get_option('home'); ?>"><img title="" src="<?php echo get_template_directory_uri(); ?>/resources/images/logosPaises/logoAzul_BBVA.svg" /></a></span> 
                      <span id="header_logoPaisClaim"><?php bloginfo('name'); ?></span> 
                    </h1>
                </div>
			</section>
            
            <section id="header_buscadorGeneral">
            	<div class="wrapperContent">
                    <div class="wrapperPosicionado">
                        <p id="buscadorGeneral_lupa"> <a id="toggleBuscadorGeneral" class="icon-lupa closed" href="#"><span class="textoIconoOcultar">Busca en nuestra web</span></a></p>
                    	<div class="componente_BUSCADORgeneral" id="buscadorGeneralExtensible" style="display:none;">                             
                            <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <fieldset>
                                    <label class="screen-reader-text" for="s"><?php _e('Realiza una nueva búsqueda'); ?></label>
                                    <input type="text" placeholder="<?php _e('Escriba aquí su búsqueda'); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />                                    
                                	<!-- meter el boton de buscar solo para el movil -->
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
          	</section>
            
            <nav id="menu_navegacionPrincipal">
            	<div class="wrapperContent">
                	<p class="menu_mainMenu_smartphone">
                        <a href="javascript:void(0)" id="toggleMainMenuSmartphone" class="icon-mainmenuSmartphone closed">
                            <span class="textoIconoOcultar">Menu de Navegación de la web</span>
                        </a>
                    </p>
                    <div id="menuPrincipalWeb_mostrarClick_movil">
						<?php wp_nav_menu( array('menu' => $menu_header )); ?>
                    </div>
				</div>
            </nav>
            
            <section id="header_tools">
            	<div class="wrapperContent">
            		<div class="wrapperPosicionado">
                         <div id="toolsWeb_mostrarClick_movil">
                              <ul id="recursivos_redesFollow" class="redesFollow">                          
                                <li class="item_01"><a href="https://www.facebook.com/GrupoBBVA" target="_blank" class="icon-social_FB"><span class="textoIconoOcultar">Facebook</span></a></li>
                                <li class="item_02"><a href="https://twitter.com/bbva" target="_blank"  class="icon-social_TW"><span class="textoIconoOcultar">Twitter</span></a></li>
                                <li class="item_03"><a href="https://www.linkedin.com/company/bbva" target="_blank"  class="icon-social_IN"><span class="textoIconoOcultar">Linkedin</span></a></li>
                                <li class="item_04"><a href="https://plus.google.com/116515550915076317173/posts" target="_blank"  class="icon-social_GO"><span class="textoIconoOcultar">Google+</span></a></li>
                                <li class="item_05 last"><a href="https://www.youtube.com/user/bbva" target="_blank"  class="icon-social_YT"><span class="textoIconoOcultar">Youtube</span></a></li>                              
                            </ul>
                              <ul id="recursivos_directLinks" class="directLinks">
                                <?php 
                                    if(ICL_LANGUAGE_CODE=="es"){
                                        ?>
                                        <li class="item_01"><a href="<?php echo get_home_url() . '/'; ?>preguntas-frecuentes/" class="icon-linkInterno">FAQ's</a></li>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="item_01"><a href="<?php echo get_home_url(); ?>faqs/" class="icon-linkInterno">FAQ's</a></li>
                                        <?php
                                    }
                                ?>
                                                                        
                              </ul>
                              <ul id="recursivos_idiomasPortal" class="idiomasPortal">
                                    <?php //print(get_language_links()); ?>
                              </ul>
                        </div>
                	</div>
            	</div>
          	</section>
            
    	</div>
    </header>

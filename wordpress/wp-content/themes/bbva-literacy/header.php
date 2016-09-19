<!DOCTYPE html>
<html lang="es">

<head>
<<<<<<< HEAD
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
</head>

<body>
<div class="webpage">
    <!-- header -->
    <header class="header">
        <div class="top hidden-xs">
            <!-- header > idioma -->
            <div class="container">
                <div class="languages-menu">
                    <label for="language-header" class="hidden">Idioma</label>
                    <select id="language-header" class="selectpicker">
                        <option>Español</option>
                        <option>English</option>
                    </select>
                </div>
            </div>
            <!-- header > logo -->
=======
    <!--[if IE ]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <![endif]-->
    <meta name="HandheldFriendly" content="true" />
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/resources/css/vendor.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/resources/css/app.css" />
    <title><?php echo bloginfo('name'); wp_title('|', true, "left"); ?></title>
</head>

<body>
    <div class="webpage">
        <header class="header">
            <!-- header -->
            <div class="top hidden-xs">
                <div class="container">
                    <div class="languages-menu">
                        <label for="language-header" class="hidden">Idioma</label>
                        <select id="language-header" class="selectpicker">
                            <option>Español</option>
                            <option>English</option>
                        </select>
                    </div>
                </div>
            </div>
>>>>>>> c80a9661fe37c9867c69c723644f1868a00e2751
            <div class="container">
                <div class="row vertical-align header-logo">
                    <div class="visible-xs col-xs-12 header-phone">
                        <div class="launcher-menu-mobil visible-xs font-xxxl">
                            <span class="bbva-icon-menu nav-phone-launch" aria-hidden="true"></span>
                        </div>
                        <div class="logo">
                            <a href="index.html">
                                <span class="bbva-icon-BBVA"></span>
                            </a>
                            <div class="text-right header-text-xs">
                                <span>Educacion Financiera</span>
                            </div>
                            <div class="logo-search ml-sm">
                                <span class="bbva-icon-search"></span>
                            </div>
                        </div>
                    </div>
<<<<<<< HEAD

=======
>>>>>>> c80a9661fe37c9867c69c723644f1868a00e2751
                    <div class="hidden-xs col-xs-12 col-sm-2 col-md-2 col-lg-4 logo">
                        <a href="index.html">
                            <span class="bbva-icon-BBVA"></span>
                            <span class="hidden">Logo BBVA</span>
                        </a>
                    </div>
                    <div class="hidden-xs col-xs-12 col-sm-6 col-sm-offset-4 col-md-5 col-md-offset-5 col-lg-4 col-lg-offset-4 header-text">
                        <h1>Educacion Financiera</h1>
                    </div>
                </div>
            </div>
<<<<<<< HEAD
         </div>
    </header>
    
    <!-- navbar menu -->
    <div class="nav-content open">
        <div class="container">
            <nav class="navbar">
                <!-- nav > solo movil -->
                <div class="row visible-xs">
                    <div class="col-xs-12 pt-md">
                        <div class="menu-logo">
                         <a href="<?php echo get_option('home'); ?>">
                              <span class="bbva-icon-BBVA"></span>
                          </a>
                        </div>
                        <div class="menu-text ml-md">
                          <span><?php bloginfo('name'); ?></span>
                        </div>
                        <div class="menu-close ml-xxxl">
                          <a role="button" class="visible-xs nav-phone-launch"><span class="bbva-icon-close"></span></a>
                        </div>
                    </div>
                </div>
                <!-- nav > solo desktop -->
                <?php wp_nav_menu( array('menu' => $menu_header )); ?>
                
                <!-- nav > buscador -->
                <div class="hidden-xs logo-search ml-sm pt-xs font-xl">
                    <span class="bbva-icon-search"></span>
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
                
                <!-- nav > idioma solo movil -->
                <div class="visible-xs">
                    <div class="languages-menu pb-lg pl-lg">
                        <a role="button" class="languages-mobile-button font-lg active"><span class="language">Español</span></a>
                        <a role="button" class="languages-mobile-button font-lg ml-lg "><span class="language">Inglés</span></a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
=======
            <!-- EO header -->
        </header>
        
        <div class="nav-content open">
            <!-- navbar menu -->
            <div class="container">
                <nav class="navbar">
                    <div class="row visible-xs">
                        <div class="col-xs-12 pt-md">
                            <div class="menu-logo">
                                <a href="index.html">
                                    <span class="bbva-icon-BBVA"></span>
                                </a>
                            </div>
                            <div class="menu-text ml-md">
                                <span>Educacion Financiera</span>
                            </div>
                            <div class="menu-close ml-xxxl">
                                <a role="button" class="visible-xs nav-phone-launch"><span class="bbva-icon-close"></span></a>
                            </div>
                        </div>
                    </div>
                    <?php
                        $args = array(
                            'menu' => $menu_header, 
                            'theme_location' => '',
                            'container' => '', 
                            'container_class' => '', 
                            'container_id' => '', 
                            'menu_class' => 'nav navbar-nav', 
                            'menu_id' => 'topmenu',
                            'depth' => 1,
                            'walker' => new Custom_Walker_Nav_Menu
                        );
                        wp_nav_menu($args);
                    ?>
                    <div class="hidden-xs logo-search ml-sm pt-xs font-xl">
                        <span class="bbva-icon-search"></span>
                    </div>
                    <div class="visible-xs">
                        <div class="languages-menu pb-lg pl-lg">
                            <a role="button" class="languages-mobile-button font-lg active"><span class="language">Español</span></a>
                            <a role="button" class="languages-mobile-button font-lg ml-lg "><span class="language">Inglés</span></a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        
        <div class="contents">
>>>>>>> c80a9661fe37c9867c69c723644f1868a00e2751

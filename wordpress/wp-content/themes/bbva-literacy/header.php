<!DOCTYPE html>
<html lang="es">

<head>
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
    <?php wp_head(); ?>
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
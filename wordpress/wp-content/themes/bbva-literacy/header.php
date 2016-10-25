<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!--[if IE ]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
    <meta name="HandheldFriendly" content="true" />
    <meta charset= "<?php bloginfo('charset'); ?>">
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
            <?php languages_list_header(); ?>
            <div class="container stycky-menu-in-mobile">
                <div class="row vertical-align header-logo">
                    <div class="visible-xs col-xs-12 header-phone text-center">
                        <div class="launcher-menu-mobil visible-xs"><span class="bbva-icon-menu nav-phone-launch" aria-hidden="true"></span></div>
                        <div class="logo"><a href="<?php echo get_home_url(); ?>" class="bbva-icon-BBVA-wrap"><span class="bbva-icon-BBVA"></span></a>
                            <h1><?php echo bloginfo('name'); ?></h1>
                            <div class="logo-search ml-sm search-mobile-button"><span class="bbva-icon-search"></span></div>
                        </div>
                    </div>
                    <div class="hidden-xs col-xs-12 col-sm-2 col-md-2 col-lg-4 logo"><a href="<?php echo get_home_url(); ?>" class="bbva-icon-BBVA-wrap"><span class="bbva-icon-BBVA"></span><span class="hidden"><?php _e('Logo BBVA'); ?></span></a></div>
                    <div class="hidden-xs col-xs-12 col-sm-6 col-sm-offset-4 col-md-5 col-md-offset-5 col-lg-4 col-lg-offset-4 header-text">
                        <h1><?php echo bloginfo('name'); ?></h1></div>
                </div>
            </div>
            <div class="search-mobile closed hidden-sm hidden-md hidden-lg">
                <div class="container">
                    <div class="header-phone">
                        <div class="logo"><a href="<?php echo get_home_url(); ?>" class="bbva-icon-BBVA-wrap"><span class="bbva-icon-BBVA"></span></a>
                            <h1><?php _e('Educación Financiera'); ?></h1></div>
                        <div class="close-search-mobile ml-sm"><span class="bbva-icon-close"></span></div>
                    </div>
                    <section class="content">
                        <div id="mobile-filter" class="publishing-filter-wrapper-mobile">
                            <header>
                                <div class="form-group has-feedback">
                                    <input type="text" class="publishing-filter-search-input form-control" name="publishing-filter-search-input" /><span class="bbva-icon-search form-control-feedback"></span></div>
                                <div class="selected-tags-container"></div>
                                <div class="button-filter"><a href="results.html" class="btn-bbva-aqua publishing-filter-search-btn" type="button" name="publishing-filter-search-btn"><?php _e('Buscar'); ?></a></div>
                            </header>
                            <section>
                                <div class="row available-tags-wrapper">
                                    <div class="col-xs-12">
                                        <p class="text-capitalize column-name"><?php _e('tags'); ?> (<span class="tag-container-counter">0</span>)</p>
                                        <div class="tag-container"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <p class="text-capitalize column-name"><?php _e('Autores'); ?> (<span class="author-container-counter">0</span>)</p>
                                        <div class="author-container"></div>
                                    </div>
                                    <div class="col-xs-12">
                                        <p class="text-capitalize column-name"><?php _e('ambito geográfico'); ?> (<span class="geo-container-counter">0</span>)</p>
                                        <div class="geo-container"></div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </section>
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
                            <div class="menu-logo"><a href="<?php echo get_home_url(); ?>"><span class="bbva-icon-BBVA"></span></a></div>
                            <div class="menu-text ml-md"><span><?php echo bloginfo('name'); ?></span></div>
                            <div class="menu-close ml-xxxl"><a role="button" class="visible-xs nav-phone-launch"><span class="bbva-icon-close"></span></a></div>
                        </div>
                    </div>
                    <?php
                        $args = array(
                            'menu' => 'menu-principal', 
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
                    <div class="hidden-xs logo-search"><span class="search-icon bbva-icon-search"></span>
                        <div class="search-form-container hidden">
                            <input class="input-search navbar-search-input" type="text" name="publishing-filter-search-input" value="">
                            <button class="btn-bbva-aqua publishing-filter-search-btn" type="button" name="publishing-filter-search-btn"><?php _e('Buscar'); ?></button>
                            <button type="button" class="close close-navbar-filter btn-close"><span class="icon bbva-icon-close"></span></button>
                        </div>
                    </div>
                    <?php languages_list_header_responsive(); ?>
                </nav>
                <div class="navbar navbar-search">
                    <div id="menu-search" class="content menu-filter-wrapper container hidden filter-container nopadding">
                        <header>
                            <div class="form-wrapper">
                                <div class="title"><span class="text-uppercase text"><?php _e('filtros'); ?></span>
                                    <button type="button" class="close close-menu-filter btn-close"><span class="icon bbva-icon-close"></span></button>
                                </div>
                            </div>
                            <div class="selected-tags-container"></div>
                        </header>
                        <section>
                            <div class="row available-tags-wrapper">
                                <div class="col-xs-4">
                                    <p class="text-uppercase column-name"><?php _e('tags'); ?> (<span class="tag-container-counter">0</span>)</p>
                                    <div class="tag-container"></div>
                                </div>
                                <div class="col-xs-4">
                                    <p class="text-uppercase column-name"><?php _e('Autores'); ?> (<span class="author-container-counter">0</span>)</p>
                                    <div class="author-container"></div>
                                </div>
                                <div class="col-xs-4">
                                    <p class="text-uppercase column-name"><?php _e('ámbito geográfico'); ?> (<span class="geo-container-counter">0</span>)</p>
                                    <div class="geo-container"></div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- EO navbar menu -->
        </div>
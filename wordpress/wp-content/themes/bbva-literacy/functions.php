<?php
	
// Registro del menú de WordPress
	add_theme_support( 'nav-menus' );
	if ( function_exists( 'register_nav_menus' ) )
	register_nav_menus(
		array(
		  'main' => 'menu_header'
		)
	);

//Registro de widget 
	
 
//Registro de sidebar
 
if(function_exists('register_sidebar')) {
	
	register_sidebar( array(
		'name'          => 'Main Sidebar',
		'id'            => 'sidebar-0',
        'description'   => __( 'Sidebar Principal, columna completa', '' ),
		'class'         => '',
		'before_widget' => '',
		'after_widget'  => '',
        'before_title'  => '',
		'after_title'   => '',
	) );
	
}
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
 
if(function_exists('register_sidebar'))
	
	register_sidebar( array(
		'name'          => 'Main Sidebar',
		'id'            => 'sidebar-0',
		'description'   => '',
        'class'         => '',
        'before_widget' => '<section class="moduloContenido_%2$s"><div class="wrapperContent">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoPpal ColCompleta',
		'id'            => 'sidebar-1',
		'description'   => __( 'Sidebar del Grupo Principal, columna completa', '' ),
		'class'         => '',
		'before_widget' => '',
		'after_widget'  => '',
        'before_title'  => '',
		'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoPpal ColPrincipal',
		'id'            => 'sidebar-2',
		'description'   => __( 'Sidebar del Grupo Principal, columna principal', '' ),
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoPpal ColDerecha', 
		'id'            => 'sidebar-3',
		'description'   => __( 'Sidebar del Grupo Principal, columna derecha', '' ),'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoSec ColCompleta',
		'id'            => 'sidebar-4',
		'description'   => __( 'Sidebar del Grupo Secundario, columna completa', '' ),
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoSec ColPrincipal',
		'id'            => 'sidebar-5',
		'description'   => __( 'Sidebar del Grupo Secundario, columna principal', '' ),
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoSec ColDerecha', 
		'id'            => 'sidebar-6',
		'description'   => __( 'Sidebar del Grupo Secundario, columna derecha', '' ),
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );

?>
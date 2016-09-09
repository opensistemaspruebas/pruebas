<?php
	

// Registro del menú de WordPress
add_theme_support('nav-menus');
if (function_exists('register_nav_menus')) {
	register_nav_menus(
		array(
		  'main' => 'menu_header'
		)
	);
}
	

// Registro de sidebar
if (function_exists('register_sidebar')) {
	register_sidebar(
		array(
			'name' => 'Main Sidebar',
			'id' => 'sidebar-0',
			'description' => __('Sidebar Principal, columna completa'),
			'class' => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>'
		)
	);
}
	

// Devuelve todas las etiquetas de un post separadas por comas
function get_all_tags_from_post($post_id) {
	
	$coauthors = get_coauthors($post_id);
	$authors = array();
	
	foreach ($coauthors as $coauthor) {
		$display_name = $coauthor->data->display_name;
		$display_name = getCleanedString($display_name);
		array_push($authors, $display_name);
	}
	
	$tags = wp_get_post_terms(
		$post_id, 
		array(
			'post_tag', 
			'category',
			'country'
		), 
		array(
			"fields" => "names"
		)
	);

	for ($i = 0; $i < count($tags); $i++) { 
		$tags[$i] = getCleanedString($tags[$i]);
	}
	
	$all_tags = array_merge($authors, $tags);
	$all_tags_separadas_por_comas = implode(",", $all_tags);
	
	return $all_tags_separadas_por_comas;
}


// Devuelve los metas del buscador para incluirlos en el post
function get_search_meta_for_post($post) {
	
	$meta = '';

	$post_title = getCleanedString($post->post_title);
	$post_content = getCleanedString($post->post_content);

	$thumbID = get_post_thumbnail_id($post->ID );
	$imgDestacada = wp_get_attachment_url($thumbID);

	$meta .= '<meta name="wp_search" content="true">';
	$meta .= '<meta name="wp_date" content="' . $post->post_date . '">';
	$meta .= '<meta name="wp_title" content="' . $post_title . '">';
	$meta .= '<meta name="image_src" content="' . $imgDestacada . '">';
	$meta .= '<meta name="wp_content" content="' . $post_content . '">';
	$meta .= '<meta name="wp_category" content="' . get_all_tags_from_post($post->ID) . '">';
	$meta .= '<meta name="wp_topic" content="' . get_post_type($post->ID) . '">';

	return $meta;
}


// Limpia cadenas de carácteres
function getCleanedString($cadena) {
	
	$cadena = strip_tags($cadena);
	$cadena = normaliza($cadena);
	$cadena = preg_replace("/[^a-zA-Z0-9]/", " ", $cadena);
	$cadena = preg_replace('/\s+/', ' ',$cadena);
	$cadena = trim($cadena);
	$cadena = strtolower($cadena);
	
	return $cadena;

}

// Normaliza cadenas de carácteres
function normaliza($cadena){
    
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    
    return utf8_encode($cadena);
}
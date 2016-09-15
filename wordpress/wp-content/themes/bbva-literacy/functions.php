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
			'description' => __('Sidebar Principal'),
			'class' => '',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	

}
	

// Añadir css y js del tema
function add_theme_scripts() {
	wp_enqueue_style('style', get_stylesheet_uri());
	wp_enqueue_style('app', get_template_directory_uri() . '/resources/css/app.css');
	wp_enqueue_style('vendor', get_template_directory_uri() . '/resources/css/vendor.css');
	wp_enqueue_script('script-os', get_template_directory_uri() . '/resources/js/script-os.js', array ('jquery' ), 1.1, true);
	wp_enqueue_script('jquery.min', get_template_directory_uri() . '/resources/js/jquery.min.js');
    wp_enqueue_script('bootstrap.min', get_template_directory_uri() . '/resources/js/bootstrap.min.js');
    wp_enqueue_script('jquery.mmenu.min.all', get_template_directory_uri() . '/resources/js/jquery.mmenu.min.all.js');
    wp_enqueue_script('jquery-ui.min', get_template_directory_uri() . '/resources/js/jquery-ui.min.js');
    wp_enqueue_script('js.cookie', get_template_directory_uri() . '/resources/js.cookie.js');
    wp_enqueue_script('bootstrap-select.min', get_template_directory_uri() . '/resources/bootstrap-select.min.js');
    wp_enqueue_script('modernizr', get_template_directory_uri() . '/resources/js/modernizr.js');
    wp_enqueue_script('wow.min', get_template_directory_uri() . '/resources/js/wow.min.js');
    wp_enqueue_script('picturefill.min', get_template_directory_uri() . '/resources/js/picturefill.min.js');
    wp_enqueue_script('app', get_template_directory_uri() . '/resources/js/app.js');
	//wp_enqueue_script("jquery");
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


// Quitar del menú las entradas por defecto
function remove_default_post_type() {
	remove_menu_page('edit.php');
}
add_action('admin_menu','remove_default_post_type');


// Devuelve todas las etiquetas de un post separadas por comas
function get_all_tags_from_post($post_id) {
	
	/*$coauthors = get_coauthors($post_id);*/
	$authors = array();
	
	/*foreach ($coauthors as $coauthor) {
		$display_name = $coauthor->data->display_name;
		$display_name = getCleanedString($display_name);
		array_push($authors, $display_name);
	}*/
	
	$tags = wp_get_post_terms(
		$post_id, 
		array(
			'category',
			'ambito_geografico'
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
	$post_excerpt = wp_strip_all_tags(get_the_excerpt());
	$post_content = getCleanedString($post->post_content);
	$post_type = get_post_type($post->ID);

	if ($post_type == "publicacion") {
		$content = $post_excerpt;
	} else {
		$content = $post_content;
	}

	$thumbID = get_post_thumbnail_id($post->ID );
	$imgDestacada = wp_get_attachment_url($thumbID);

	$meta .= '<meta name="wp_search" content="true">';
	$meta .= '<meta name="wp_date" content="' . $post->post_date . '">';
	$meta .= '<meta name="wp_title" content="' . $post_title . '">';
	$meta .= '<meta name="image_src" content="' . $imgDestacada . '">';
	$meta .= '<meta name="wp_content" content="' . $content . '">';
	$meta .= '<meta name="wp_category" content="' . get_all_tags_from_post($post->ID) . '">';
	$meta .= '<meta name="wp_topic" content="' . $post_type . '">';

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


/*function literacy_add_search_meta() {
    $post_type = get_post_type();
    if ($post_type == 'product' && is_single()): $product = get_product( get_the_ID() ); $attrs = beeva_get_atts($product);
        ?>
        <meta name="wp_search" content="true"/>
        <meta name="wp_content" content="<?=htmlentities(str_replace(array("\r\n","\n"),'',strip_tags($product->post->post_content)))?>"/>
        <meta name="wp_title" content="<?=$product->post->post_title?>">
        <meta name="keywords" content="<?=implode($attrs,',')?>"/>
        <meta name="date" content="<?=get_the_date('Y-m-d'); ?>"/>
        <meta name="topic" content="<?=get_post_type() ?>"/>
        <?php if ( has_post_thumbnail() ) : ?>
            <meta name="image_src" content="<?=str_replace('http://ec2-52-209-71-102.eu-west-1.compute.amazonaws.com','',get_the_post_thumbnail_url())?>"/>
        <? endif; ?>
        <? $cat = get_the_category(); if($cat && count($cat)): ?>
            <meta name="category" content="<?=$cat[0]->name ?>"/>
        <? endif; ?>
    <? endif;
}*/
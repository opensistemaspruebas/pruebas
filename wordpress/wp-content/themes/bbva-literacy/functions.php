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


// Quitar del menú las entradas por defecto
function remove_default_post_type() {
	remove_menu_page('edit.php');
}
add_action('admin_menu','remove_default_post_type');


// Obtiene las etiquetas de un post
function get_atts($post) {
    return wp_get_post_terms(get_the_ID(), array('category', 'ambito_geografico'), array('fields'=>'ids'));
}


// Pinta los metas para el buscador
function add_search_meta() {
    
    $post_type = get_post_type();
    
    $types = array('publicacion', 'historia', 'taller');
    
    if (in_array($post_type, $types) && is_single()) : $p = get_post(get_the_ID()); $attrs = get_atts($p);
    	$post_content = '';
    	if ($post_type == 'publicacion') {
    		$post_content = get_post_meta($p->ID, 'abstract_destacado', true) . ' ' . get_post_meta($p->ID, 'abstract_contenido', true);
    		$post_content = getCleanedString($post_content);
    	} else {
    		$post_content = getCleanedString($p->post_content);
    	}
        ?>
        <meta name="wp_search" content="true"/>
        <meta name="wp_content" content="<?php echo $post_content; ?>"/>
        <meta name="wp_title" content="<?php echo getCleanedString($p->post_title); ?>"/>
        <meta name="wp_text_array" content="<?php echo getCleanedString(get_the_author_meta('display_name', $p->post_author)); ?>"/>
        <meta name="wp_double_array" content="<?php echo implode($attrs, ','); ?>"/>
        <meta name="wp_date" content="<?php echo get_the_date('Y-m-d'); ?>"/>
        <meta name="wp_topic" content="<?php echo get_post_type(); ?>"/>
        <?php if (has_post_thumbnail()) : ?>
            <meta name="image_src" content="<?php echo str_replace('http://ec2-52-209-71-102.eu-west-1.compute.amazonaws.com', '', get_the_post_thumbnail_url()); ?>"/>
        <?php endif; ?>
    <?php endif;
}
add_action('wp_head', 'add_search_meta', 100);


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


// Obtiene el id de un attachment por su url
function get_attachment_id_by_url($url) {
	$parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );
	$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
	if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}
	global $wpdb;
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ));
	return $attachment[0];
}


// Adapto menú a nuestros estilos
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		$output .= $indent . '<li class="panel">';
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		$item_output = $args->before;
		$item_output .= '<a class="collapsed mr-sm" '. $attributes .'>';
		$item_output .= '<span class="hidden-xs">' . $title . '</span>';
		$item_output .= '<span class="visible-xs pl-lg">' . $title . '</span>';
		$item_output .= '</a>';
		$item_output .= '<a class="hidden" role="button" data-toggle="collapse" data-parent="#topmenu" data-target="#publish">';
        $item_output .= '<span>' . $title . '</span>';
        $item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }
}